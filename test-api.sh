curl -X POST https://backend-production-18d4.up.railway.app/api/alert \
  -H "Content-Type: application/json" \
  -d '{"email":"test@test.com","currency":"USD","threshold":3.0}'
