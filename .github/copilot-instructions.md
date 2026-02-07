# Copilot instructions — Car Rental PHP app

Summary
- Small PHP monolith served from XAMPP (htdocs/DATABASE). Files are plain PHP + inline HTML.
- Session-based auth (customer_id in session); DB is MySQL (dbname seen: `Car Rental`).

Quick architecture notes
- Single-site PHP pages (no framework). Key files:
  - `db.php` — creates `$conn = mysqli_connect(...)` and calls `session_start()` (required include).
  - `login.php` / `signup.php` / `dashboard.php` — authentication and simple navigation.
  - `rent.php` / `book_car.php` — search and booking flows; `book_car.php` inserts a booking and sets car status.
  - `rentals.php` — reads booking history but uses `$pdo` (inconsistent with `db.php`).
  - `csv/` — data CSVs (cars, models, employees) likely used for manual imports.

Data flow & common patterns
- Auth: `login.php` looks up `phone_no`, sets `$_SESSION['customer_id']`, and sets a `phone_no` cookie for convenience.
- Authorization guard: many pages check `if (!isset($_SESSION['customer_id'])) header("Location: login.php");` — preserve this pattern.
- DB access pattern: most code uses procedural `mysqli` via `$conn`; some files (e.g. `rentals.php`) use `$pdo` and prepared statements. Expect mixed DB APIs.
- SQL usage: lots of direct string interpolation (e.g., `SELECT * FROM customer WHERE phone_no='$phone'`) — avoid introducing similar insecure patterns. Prefer prepared statements when modifying DB code.

Developer workflows & environment
- Run in XAMPP (macOS path seen): files live under `/Applications/XAMPP/xamppfiles/htdocs/DATABASE`.
- Start services using the XAMPP control app or via CLI: `/Applications/XAMPP/xamppfiles/xampp start` (Apache + MySQL). Access in browser at `http://localhost/DATABASE/`.
- No test harness present; manual verification is by visiting pages and observing DB state. Use `php -S` only for PHP, but still requires a running MySQL instance.

Integration points & external dependencies
- MySQL database (schema tables referenced: `customers`, `cars`, `models`, `categories`, `bookings`, `branches`, `fines`).
- CSV files in `csv/` indicate import/export workflows — inspect these before changing data-import logic.

Important conventions & gotchas for an AI agent
- Always include `db.php` at top when editing/creating pages (it provides `$conn` and starts session).
- Preserve session checks and redirects used for auth guards.
- Check for `$pdo` usage before switching DB APIs: either update `db.php` to expose a PDO instance or convert the few `$pdo` files to use `$conn` consistently. Do not change one file in isolation.
- Avoid raw string SQL interpolation. If you must change SQL, replace it with prepared statements and run a quick manual test.
- UI is inline HTML; minimal JS. Keep new views simple and follow the same inline style.

Examples to reference
- Login: `login.php` uses phone-only login, sets `$_SESSION['customer_id']` and `setcookie('phone_no', $phone, ...)`.
- Booking: `book_car.php` inserts into `bookings` and runs `UPDATE cars SET status='booked'` immediately after.
- Price calc: `rent.php` computes `base_daily_rate * (1 + condition_factor)` — preserve the formula if touching pricing.

What to do when changing DB layer
1. Search for `$pdo` and `$conn` occurrences (they are mixed). If standardizing, update `db.php` to provide both or convert callers in a single PR.
2. Add prepared statements for any SQL that uses interpolated user input (e.g., phone numbers, IDs from GET/POST).
3. Run manual flow: signup -> login -> rent -> book -> rentals to validate changes.

Debugging tips
- Enable errors in development via `ini_set('display_errors',1); error_reporting(E_ALL);` at top of `db.php` temporarily.
- Apache/PHP error log: `/Applications/XAMPP/xamppfiles/logs/error_log`.

If something is unclear
- Ask for the intended long-term DB API (keep `mysqli` or migrate to `PDO`) and whether automatic tests/import scripts should be added.

-- End --
