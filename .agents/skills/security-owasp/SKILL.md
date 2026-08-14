---
name: security-owasp
description: >-
  Security auditing, OWASP Top 10 defense, and vulnerability prevention skill.
  Use this skill when implementing authentication, authorization, session management,
  file uploads, API endpoints, payment gateways, database queries, and input validation.
---

# Security & OWASP Defense Skill

Enterprise security standards, vulnerability mitigation, and automated SAST auditing guidelines for web applications.

---

## 1. OWASP Top 10 Mitigation Guidelines

### A. Broken Access Control (A01)
- Verify authorization on **every** controller action using Policies or Gates (`$this->authorize('update', $model)`).
- Never trust client-supplied IDs (e.g. `user_id` from hidden form inputs); always bind to the authenticated session (`$request->user()->id`).
- Ensure all admin routes are enclosed in `Route::middleware(['auth', 'verified'])`.

### B. Cryptographic Failures & Sensitive Data (A02)
- Store all passwords hashed with bcrypt / argon2id (`Hash::make($password)`).
- Store API keys, tokens, and credentials strictly in `.env` and retrieve via `config()`. Never commit secrets to version control.
- Mask sensitive data (passwords, tokens, credit card numbers) in logs and error traces.

### C. Injection Attacks (SQLi, Command Injection, XSS) (A03)
- **SQL Injection:** Use Eloquent ORM or parameterized query bindings (`DB::select('SELECT * FROM users WHERE email = ?', [$email])`). Never concatenate unescaped user input into raw SQL queries.
- **Cross-Site Scripting (XSS):** Rely on Blade's `{{ $var }}` auto-escaping. Sanitize rich HTML before storing or rendering with `{!! !!}`.
- **Command Injection:** Avoid running shell commands directly with untrusted user input; sanitize and validate arguments strictly.

### D. Insecure Design & File Uploads (A04)
- Restrict uploaded file types with explicit MIME validation (`'image' => 'required|file|mimes:jpeg,png,webp,jpg|max:5120'`).
- Never execute uploaded files in public storage; randomize file names (`Str::uuid()`) and store in non-executable storage directories.
- Automatically re-encode / convert images to WebP to strip embedded malicious EXIF payloads.

### E. Security Misconfiguration & Rate Limiting (A05)
- In production, set `APP_DEBUG=false` to prevent stack traces leaking environment secrets.
- Enforce strict Rate Limiting (`throttle:60,1` or `throttle:login`) on public login, contact, and quote submission endpoints.
- Enable HTTP security headers: `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Referrer-Policy: strict-origin-when-cross-origin`.

### F. Identification & Authentication Failures (A07)
- Regenerate session ID upon login (`$request->session()->regenerate()`) to prevent Session Fixation.
- Enforce strong password complexity rules (`Password::min(8)->letters()->mixedCase()->numbers()->symbols()`).
- Implement brute-force protection with account lockout or throttle delay.

---

## 2. Verification & Audit Routine

- Regularly scan dependencies for known CVEs:
  ```bash
  composer audit
  npm audit
  ```
- Review `.env` files to ensure sensitive values are not exposed in public repositories.
