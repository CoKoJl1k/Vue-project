<script setup>
import { ref, onMounted } from 'vue'
import { Line } from 'vue-chartjs'
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
} from 'chart.js'

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend)

const currencies = ref([])
const selected = ref('USD')
const period = ref('1m')
const loading = ref(true)

const notifyEmail = ref('')
const notifyCurrency = ref('USD')
const notifyThreshold = ref(3.0)
const notifyBotToken = ref('')
const notifyChatId = ref('')
const notifyStatus = ref('')

const periods = [
  { value: '1m', label: '1 месяц' },
  { value: '3m', label: '3 месяца' },
  { value: '6m', label: '6 месяцев' },
  { value: '1y', label: '1 год' },
]

const chartData = ref(null)
const chartOptions = {
  responsive: true,
  plugins: {
    legend: { display: false },
  },
  scales: {
    y: {
      ticks: { callback: (v) => v.toFixed(2) },
    },
  },
}

onMounted(async () => {
  try {
    const res = await fetch('https://api.nbrb.by/exrates/rates?periodicity=0', { headers: { Accept: 'application/json' } })
    const data = await res.json()
    currencies.value = data.filter((c) => ['USD', 'EUR', 'RUB', 'CNY', 'GBP', 'PLN'].includes(c.Cur_Abbreviation))
  } catch {
    currencies.value = [
      { Cur_Abbreviation: 'USD', Cur_OfficialRate: 0.0, Cur_Name: 'Доллар США' },
      { Cur_Abbreviation: 'EUR', Cur_OfficialRate: 0.0, Cur_Name: 'Евро' },
      { Cur_Abbreviation: 'RUB', Cur_OfficialRate: 0.0, Cur_Name: 'Российский рубль', Cur_Scale: 100 },
      { Cur_Abbreviation: 'CNY', Cur_OfficialRate: 0.0, Cur_Name: 'Китайский юань', Cur_Scale: 10 },
    ]
  }
  loading.value = false
  await loadChart()
})

async function loadChart() {
  const cur = currencies.value.find((c) => c.Cur_Abbreviation === selected.value)
  if (!cur) return

  const end = new Date()
  const start = new Date()
  const days = { '1m': 30, '3m': 90, '6m': 180, '1y': 365 }
  start.setDate(start.getDate() - (days[period.value] || 30))

  const fmt = (d) => d.toISOString().slice(0, 10)

  try {
    const res = await fetch(
      `https://api.nbrb.by/exrates/rates/dynamics/${cur.Cur_ID}?startdate=${fmt(start)}&enddate=${fmt(end)}`,
      { headers: { Accept: 'application/json' } },
    )
    const data = await res.json()
    chartData.value = {
      labels: data.map((d) => {
        const [y, m, day] = d.Date.slice(0, 10).split('-')
        return `${day}-${m}-${y}`
      }),
      datasets: [
        {
          label: selected.value,
          data: data.map((d) => d.Cur_OfficialRate),
          borderColor: '#3498db',
          tension: 0.3,
          fill: false,
        },
      ],
    }
  } catch {
    chartData.value = {
      labels: Array.from({ length: 7 }, (_, i) => `${i + 1}`),
      datasets: [
        {
          label: selected.value,
          data: Array.from({ length: 7 }, () => Math.random() * 0.2 + 3.1),
          borderColor: '#3498db',
          tension: 0.3,
          fill: false,
        },
      ],
    }
  }
}

async function saveNotification() {
  notifyStatus.value = ''
  const res = await fetch('/api/alert', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ email: notifyEmail.value, currency: notifyCurrency.value, threshold: notifyThreshold.value, telegram_bot_token: notifyBotToken.value, telegram_chat_id: notifyChatId.value }),
  })
  const data = await res.json()
  notifyStatus.value = data.ok ? '✅ Настройки сохранены' : '❌ ' + (data.error || 'Ошибка')
}

function formatRate(rate, scale = 1) {
  return (rate / scale).toFixed(2)
}

function convert(from, amount) {
  const cur = currencies.value.find((c) => c.Cur_Abbreviation === from)
  if (!cur) return 0
  const byn = (cur.Cur_OfficialRate / (cur.Cur_Scale || 1)) * amount
  return byn.toFixed(2)
}
</script>

<template>
  <div class="currency-page">
    <h1>Курсы валют</h1>

    <div v-if="loading" class="loading">Загрузка...</div>

    <table v-else class="rates">
      <thead>
        <tr>
          <th>Валюта</th>
          <th>Курс к BYN</th>
          <th>Конвертер</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="cur in currencies" :key="cur.Cur_Abbreviation">
          <td>{{ cur.Cur_Abbreviation }} — {{ cur.Cur_Name }}</td>
          <td>{{ formatRate(cur.Cur_OfficialRate, cur.Cur_Scale) }} BYN</td>
          <td>
            1 {{ cur.Cur_Abbreviation }} =
            {{ formatRate(cur.Cur_OfficialRate, cur.Cur_Scale) }} BYN
          </td>
        </tr>
      </tbody>
    </table>

    <div class="chart-section">
      <h2>График</h2>
      <select v-model="selected" @change="loadChart">
        <option v-for="cur in currencies" :key="cur.Cur_Abbreviation" :value="cur.Cur_Abbreviation">
          {{ cur.Cur_Abbreviation }}
        </option>
      </select>

      <select v-model="period" @change="loadChart">
        <option v-for="p in periods" :key="p.value" :value="p.value">
          {{ p.label }}
        </option>
      </select>

      <div class="chart-wrapper" v-if="chartData">
        <Line :data="chartData" :options="chartOptions" />
      </div>
      <p v-else class="loading">Загрузка графика...</p>
    </div>

    <div class="notify-section">
      <h2>Уведомление в Telegram</h2>
      <p>Информация будет отправлена в Telegram бот</p>
      <input v-model="notifyEmail" placeholder="your@email.com" class="notify-input" />
      <label>Валюта:</label>
      <select v-model="notifyCurrency">
        <option v-for="cur in currencies" :key="cur.Cur_Abbreviation" :value="cur.Cur_Abbreviation">
          {{ cur.Cur_Abbreviation }}
        </option>
      </select>
      <label>Порог (BYN):</label>
      <input v-model.number="notifyThreshold" type="number" step="0.01" class="notify-input" />
      <label>Токен бота:</label>
      <input v-model="notifyBotToken" placeholder="Telegram bot token" class="notify-input" />
      <label>Chat ID:</label>
      <input v-model="notifyChatId" placeholder="Telegram chat ID" class="notify-input" />
      <button @click="saveNotification">Сохранить</button>
      <p v-if="notifyStatus" v-text="notifyStatus" />
    </div>
  </div>
</template>

<style scoped>
.currency-page {
  max-width: 100%;
}
.loading {
  color: #999;
  text-align: center;
  padding: 2rem;
}
.rates {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 2rem;
}
.rates th, .rates td {
  border: 1px solid var(--border);
  padding: 8px 12px;
  text-align: left;
}
.rates th {
  background: var(--border);
}
.chart-section {
  width: 100%;
}
.chart-section h2 {
  margin-bottom: 8px;
}
select {
  padding: 6px 12px;
  margin-bottom: 1rem;
  background: var(--bg);
  color: var(--text);
  border: 1px solid var(--border);
}
.chart-wrapper {
  background: #fff;
  padding: 1rem;
  border-radius: 8px;
  width: 100%;
  box-sizing: border-box;
}
.notify-section {
  margin-top: 2rem;
  max-width: 400px;
}
.notify-input {
  width: 100%;
  padding: 6px 10px;
  margin: 6px 0;
  box-sizing: border-box;
  background: var(--bg);
  color: var(--text);
  border: 1px solid var(--border);
}
</style>
