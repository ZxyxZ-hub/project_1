# AUTHENTICATION & SESSION MANAGEMENT GUIDE

## 🔐 How the Authentication Flow Works

### Entry Point
When user visits `localhost/project_1/public/`:
1. **Root route (/)** → Routes to `Auth::login()`
2. **Auth::login()** checks session:
   - **If logged in** → Redirects to `/form` (user) or `/admin` (admin)
   - **If NOT logged in** → Shows login form

### Login Flow
```
1. User enters email + password
2. Auth::loginSubmit() validates:
   ✓ Email exists in database
   ✓ Password matches (bcrypt verified)
   ✓ User status is "approved"
3. Session created with:
   - user_id, username, full_name, role, logged_in
4. Redirects to dashboard:
   - Admin → /admin
   - User → /form
```

### Protected Routes
All form routes require `['filter' => 'auth']`:
- /form - Index, save, delete, view, print, list

All admin routes require `['filter' => 'auth:admin']`:
- /admin - Dashboard, users, approve, deny, update role, reset password

### Logout
- **Button location**: Every protected page has a logout button
- **Action**: POST to `/auth/logout`
- **Result**: Session destroyed, redirects to login

---

## 🧪 Testing the Authentication Flow

### Test 1: Fresh Login
1. Go to `localhost/project_1/public/`
2. If redirected to `/form` → You're still logged in
3. **To test login:** Click **Logout** button first
4. Then you'll see the login page

### Test 2: Login with Default Admin
```
Email: admin
Password: admin123
→ Should redirect to /admin dashboard
```

### Test 3: Login with Test User
```
Email: user1
Password: (set by admin in database)
→ Should redirect to /form page
```

### Test 4: Session Persistence
1. Login to account
2. Close browser tab (don't logout)
3. Open new tab to `localhost/project_1/public/`
4. Session should still be active (redirects to dashboard)
5. Session expires after 2 hours (see app/Config/Session.php)

### Test 5: Unauthorized Access
1. Logout
2. Try to access `/form` directly
3. Should redirect to `/auth/login`

### Test 6: Admin-Only Routes
1. Login with regular user account
2. Try to access `/admin`
3. Should show "You do not have permission" error

---

## 📝 Logout Button Locations

✅ **form_page.php** (Form entry page)
- Top right corner next to "Close" button
- Red button with logout icon

✅ **list_page.php** (Saved data list)
- Header right side next to "Create" button
- Red button with logout icon

✅ **view_page.php** (View single form)
- Top controls bar next to "Print" button
- Red button

✅ **admin/dashboard.php** (Admin dashboard)
- Top right corner in header
- Red button

✅ **admin/users.php** (User management)
- Top right corner in header
- Red button

---

## 🔧 How to Reset Session Manually

If logout button isn't working, use one of these:

### Option 1: Clear Browser Cookies
1. Developer Tools (F12)
2. Application → Cookies
3. Delete `ci_session` cookie
4. Refresh page

### Option 2: Clear Session Files
```bash
# Delete all session files
rm -rf writable/session/*

# On Windows PowerShell:
Remove-Item writable/session/* -Force
```

### Option 3: Database Clear (if using database sessions)
```sql
DELETE FROM ci_sessions;
```

---

## 📁 Session Configuration

**File**: `app/Config/Session.php`

```php
public string $driver = FileHandler::class;           // Stores in files
public string $cookieName = 'ci_session';             // Cookie name
public int $expiration = 7200;                        // 2 hours (in seconds)
public string $savePath = WRITEPATH . 'session';      // Session file location
public bool $matchIP = false;                         // Don't match IP (allows roaming)
public int $timeToUpdate = 300;                       // Regenerate every 5 min
```

---

## 🛡️ Security Features

✅ **Password Hashing**: BCrypt (PASSWORD_BCRYPT)
✅ **Session Management**: Automatic expiration after 2 hours
✅ **Session Regeneration**: Every 5 minutes for security
✅ **CSRF Protection**: Automatic token validation
✅ **Role-Based Access**: Filter checks role before allowing access
✅ **Status Verification**: Only approved users can login

---

## 🚀 Deploy to New Device Checklist

- [ ] Copy entire project folder
- [ ] Create database: `php spark migrate`
- [ ] Create admin user or run setup
- [ ] Verify .htaccess in public/ folder
- [ ] Check $indexPage = '' in app/Config/App.php
- [ ] Test login at localhost/project_1/public/
- [ ] Verify logout button appears on protected pages
- [ ] Try accessing protected routes without login (should redirect)
- [ ] Test role-based access (admin vs user)

---

## ⚡ Logout Button Implementation

### In Views (Standard Format)
```php
<form action="<?= base_url('auth/logout') ?>" method="POST" style="margin: 0;">
    <button type="submit" class="logout-btn">Logout</button>
</form>
```

**Why POST instead of GET?**
- POST is more secure (doesn't expose in URL history)
- Requires CSRF token (automatic in CodeIgniter)
- Standard web security practice

---

## 🔍 Troubleshooting

| Issue | Cause | Solution |
|-------|-------|----------|
| Login redirects to form instead of showing login | Session still active | Click logout button |
| Logout button doesn't work | CSRF token missing | Ensure button is in form with POST |
| Session expires too fast | Wrong session driver | Check Session.php config |
| Can't access /admin as admin | User role not set to 'admin' | Check users table |
| 404 on logout | Route missing | Check Routes.php has logout route |
| Session files piling up | Garbage collection off | Check PHP ini settings |

---

## 💡 Key Code Locations

- **Authentication Logic**: [app/Controllers/Auth.php](../app/Controllers/Auth.php)
- **Auth Filter**: [app/Filters/AuthFilter.php](../app/Filters/AuthFilter.php)
- **Routes**: [app/Config/Routes.php](../app/Config/Routes.php)
- **Session Config**: [app/Config/Session.php](../app/Config/Session.php)
- **Login View**: [app/Views/auth/login.php](../app/Views/auth/login.php)
- **Protected Views**: 
  - [app/Views/form_page.php](../app/Views/form_page.php)
  - [app/Views/list_page.php](../app/Views/list_page.php)
  - [app/Views/admin/dashboard.php](../app/Views/admin/dashboard.php)
