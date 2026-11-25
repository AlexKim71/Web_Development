#!/usr/bin/env bash
# Перевірка API лабораторної №6 (WSL/Linux): 9 кейсів, статус і тіло відповіді.
# Використання:  ./test-api.sh [BASE_URL]   (за замовчуванням http://localhost:5080/api/rooms)
set -uo pipefail

BASE="${1:-http://localhost:5080/api/rooms}"
command -v curl >/dev/null || { echo "Потрібен curl: sudo apt-get install -y curl" >&2; exit 2; }

TMP="$(mktemp)"; trap 'rm -f "$TMP"' EXIT
FAILS=0
STATUS=""

# call "Назва" МЕТОД URL ОЧІКУВАНИЙ_СТАТУС [JSON-тіло]
call() {
  local title="$1" method="$2" url="$3" expected="$4" body="${5:-}"
  echo
  echo "=== $title ==="
  echo "$method $url"
  [[ -n "$body" ]] && echo "Body: $body"
  if [[ -n "$body" ]]; then
    STATUS="$(curl -s -o "$TMP" -w "%{http_code}" -X "$method" \
      -H "Content-Type: application/json; charset=utf-8" \
      --data-binary "$body" "$url" || true)"
  else
    STATUS="$(curl -s -o "$TMP" -w "%{http_code}" -X "$method" "$url" || true)"
  fi
  if [[ "$STATUS" == "$expected" ]]; then
    echo "Status: $STATUS (очікувано $expected) — OK"
  else
    echo "Status: $STATUS (очікувано $expected) — НЕВІРНО"; FAILS=$((FAILS + 1))
  fi
  cat "$TMP"; echo
}

# id першого запису з JSON-відповіді (без jq)
first_id() { grep -o '"id":"[^"]*"' "$TMP" | head -1 | cut -d'"' -f4; }

call "1. GET список" GET "$BASE" 200

call "2. POST коректний запис" POST "$BASE" 200 \
  '{"number":"501","category":"Люкс","capacity":2,"floor":5,"pricePerNight":6200.5,"isAvailable":true}'
ID501="$(first_id)"

call "3. POST місткість 0" POST "$BASE" 400 \
  '{"number":"502","category":"Стандарт","capacity":0,"floor":5,"pricePerNight":1500,"isAvailable":true}'

call "4. POST номер із пробілів" POST "$BASE" 400 \
  '{"number":"   ","category":"Стандарт","capacity":2,"floor":5,"pricePerNight":1500,"isAvailable":true}'

call "5. POST невідома категорія" POST "$BASE" 400 \
  '{"number":"503","category":"Президентський","capacity":2,"floor":5,"pricePerNight":1500,"isAvailable":true}'

call "6. POST повтор номера 101" POST "$BASE" 409 \
  '{"number":" 101 ","category":"Комфорт","capacity":2,"floor":1,"pricePerNight":1800,"isAvailable":true}'

call "7. POST поверх 0 дозволений" POST "$BASE" 200 \
  '{"number":"002","category":"Стандарт","capacity":1,"floor":0,"pricePerNight":900,"isAvailable":true}'
ID002="$(first_id)"

if [[ -n "$ID501" ]]; then
  call "8. DELETE наявного id" DELETE "$BASE/$ID501" 200
  call "9. Повторний DELETE" DELETE "$BASE/$ID501" 404
else
  echo; echo "Кейси 8–9 пропущено: не отримано id із кейсу 2 (сервер недоступний?)"; FAILS=$((FAILS + 2))
fi

# Прибирання службового запису 002, щоб тест можна було повторювати.
[[ -n "$ID002" ]] && curl -s -o /dev/null -X DELETE "$BASE/$ID002" || true

echo
if [[ "$FAILS" -eq 0 ]]; then echo "Усі кейси пройдено."; else echo "Невдалих кейсів: $FAILS"; fi
exit $(( FAILS > 0 ? 1 : 0 ))
