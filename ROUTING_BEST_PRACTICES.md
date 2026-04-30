# CodeIgniter 4 Routing Best Practices - Project_1

## ⚠️ CRITICAL: ROUTING CONFIGURATION

### Problem That Was Fixed
The project had mixed routing approaches that caused:
1. **"project_1.forms view doesn't exist"** - Views were being referenced with wrong names
2. **Redirects going to index.php instead of dashboard** - Mixed hardcoded and automatic index.php handling
3. **Broken admin actions** - Form submissions failing due to malformed URLs

---

## ✅ CORRECT SETUP (CURRENT)

### 1. App.php Configuration
```php
// app/Config/App.php
public string $indexPage = '';  // EMPTY STRING for clean URLs
```

**Why:** With Laragon/.htaccess enabled, mod_rewrite handles the redirect to index.php automatically. Setting this to empty string prevents double index.php in URLs.

### 2. .htaccess Configuration
```apache
# public/.htaccess - KEEP AS IS
RewriteRule ^([\s\S]*)$ index.php/$1 [L,NC,QSA]
```
This rewrites all requests through index.php automatically.

---

## 📋 ROUTING DO's AND DON'Ts

### ❌ NEVER DO THIS:
```php
// DON'T hardcode index.php in URLs
<a href="<?= base_url('index.php/admin/approve-user/') ?>">
<form action="<?= base_url('index.php/form/save') ?>">

// DON'T use view names that don't exist
return view('forms');  // WRONG - file is form_page.php
return view('project_1.forms');  // WRONG - nonsense

// DON'T mix route definitions with hardcoded URLs
$routes->post('form/save', 'Form::save');
// Then in view: base_url('index.php/form/save') - INCONSISTENT!
```

### ✅ ALWAYS DO THIS:
```php
// DO use clean URLs with base_url()
<a href="<?= base_url('admin') ?>">
<a href="<?= base_url('admin/approve-user/' . $userId) ?>">
<a href="<?= base_url('admin/users') ?>">
<form action="<?= base_url('form/save') ?>">

// DO use correct view names (they must match files)
return view('form_page');      // ✅ file: app/Views/form_page.php
return view('admin/dashboard'); // ✅ file: app/Views/admin/dashboard.php
return view('auth/login');      // ✅ file: app/Views/auth/login.php

// DO use site_url() for internal routing in links
<a href="<?= site_url('form/view/' . $form['id']) ?>">
<a href="<?= site_url('form/list') ?>">

// DO use consistent routes
// Routes:
$routes->post('form/save', 'Form::save', ['filter' => 'auth']);
$routes->post('form', 'Form::save', ['filter' => 'auth']);

// Views:
<form action="<?= base_url('form/save') ?>">  // ✅ Matches route
```

---

## 📚 VIEW NAMING CONVENTION

Always match the view() call with the ACTUAL FILE PATH:

```
View Name                      →  File Path
view('form_page')              →  app/Views/form_page.php
view('admin/dashboard')        →  app/Views/admin/dashboard.php
view('admin/users')            →  app/Views/admin/users.php
view('auth/login')             →  app/Views/auth/login.php
view('auth/signup')            →  app/Views/auth/signup.php
view('view_page')              →  app/Views/view_page.php
view('list_page')              →  app/Views/list_page.php
view('print_page')             →  app/Views/print_page.php
```

---

## 🔗 URL GENERATION HELPERS

### base_url()
Use for:
- Static assets: `<img src="<?= base_url('images/logo.png') ?>">`
- Form actions: `<form action="<?= base_url('form/save') ?>">`
- Manual redirects: `return redirect()->to(base_url('admin'));`

### site_url()
Use for:
- Navigation links: `<a href="<?= site_url('form/view/1') ?>">`
- AJAX endpoints: `fetch(<?= site_url('form/delete') ?>)`

### route()
Use for:
- Named routes: `<a href="<?= route('login') ?>">`
```php
// In Routes.php
$routes->get('auth/login', 'Auth::login', ['as' => 'login']);
// In View
<a href="<?= route('login') ?>">  // Uses named route
```

---

## 🛡️ PROTECTION RULES

### 1. Authentication Filter
```php
// Routes requiring login:
$routes->get('form', 'Form::index', ['filter' => 'auth']);
$routes->get('admin', 'Admin::index', ['filter' => 'auth:admin']);
```

### 2. View Protection
```php
// At top of admin views:
<?php
$session = session();
if (!$session->get('logged_in') || $session->get('role') !== 'admin') {
    return redirect()->to('/auth/login');
}
?>
```

### 3. CSRF Token
```php
// In forms:
<form method="POST">
    <?= csrf_field() ?>
    ...
</form>
```

---

## 🔄 REDIRECT FLOW

### Login Flow (Correct)
```
1. User accesses / → Auth::login view
2. User submits form → Auth::loginSubmit()
3. If admin: redirect()->to('/admin')
4. If user: redirect()->to('/form')
5. AuthFilter checks session, allows access
```

### NOT like this (WRONG):
```
1. User accesses / → redirect to index.php/auth/login ❌
2. User submits → index.php/auth/login-submit ❌
3. Redirect to index.php/admin ❌
```

---

## 🧪 TESTING CHECKLIST

When pulling to a new device:

- [ ] Verify `.htaccess` exists in `public/` folder
- [ ] Check `$indexPage = ''` in `app/Config/App.php`
- [ ] Test login: `/auth/login` (should NOT have index.php)
- [ ] After login: Should go to `/form` or `/admin` (NOT index.php)
- [ ] Admin actions: Approve/Deny/Reset should work
- [ ] Form save: Should POST correctly and return to same page
- [ ] View all routes: Check with `php spark routes`

---

## 🚀 TROUBLESHOOTING

| Problem | Cause | Fix |
|---------|-------|-----|
| "View doesn't exist" | Wrong view name in return view() | Match to actual file path |
| Redirect loops | Broken route or redirect | Use clean URLs, check filter |
| index.php in URLs | $indexPage not empty | Set $indexPage = '' |
| 404 errors on POST | Route mismatch | Check both GET and POST routes |
| Double index.php | Hardcoded in view + config | Remove from view, let config handle |
| Form not saving | Wrong form action URL | Use `base_url('form/save')` |
| Admin buttons not working | Hardcoded index.php paths | Use clean URLs in JavaScript |

---

## 📝 CONFIG SUMMARY

```php
// app/Config/App.php
public string $baseURL = 'http://localhost/project_1/public/';
public string $indexPage = '';  // ← MOST IMPORTANT!

// public/.htaccess - MUST have rewrite rules
RewriteRule ^([\s\S]*)$ index.php/$1 [L,NC,QSA]
```

---

**TLDR:** Use `base_url()` for all URLs, keep `$indexPage` empty, match view names to file paths, use filters for protection.
