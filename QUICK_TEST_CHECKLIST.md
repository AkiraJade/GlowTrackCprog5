# 🚀 Quick Test Checklist

## ⚡ 5-Minute Quick Tests

### 1. Basic Functionality (2 mins)
```bash
# Start the application
php artisan serve

# Test in browser:
# 1. Register new user at /register
# 2. Try to login (should need email verification)
# 3. Check email logs for verification
# 4. Login after verification
```

### 2. Product CRUD (1 min)
```bash
# Test as admin:
# 1. Go to /admin/products
# 2. Create new product with photo
# 3. Edit the product
# 4. Delete the product
```

### 3. Search & Filters (1 min)
```bash
# Test on homepage:
# 1. Search for "serum"
# 2. Filter by price range
# 3. Filter by category
# 4. Verify results
```

### 4. Admin Features (1 min)
```bash
# Test as admin:
# 1. Go to /admin/charts
# 2. Check if charts load
# 3. Go to /admin/users
# 4. Update user status/role
```

---

## 🔍 Detailed Feature Tests

### ✅ Email Verification Test
```bash
# Steps:
1. Register: POST /register with valid data
2. Check logs: tail storage/logs/laravel.log
3. Find verification URL in logs
4. Visit verification URL
5. Try login: POST /login
6. Should succeed now
```

### ✅ Excel Import Test
```bash
# Steps:
1. Go to /products/import
2. Download template
3. Fill with test data (2-3 rows)
4. Upload file
5. Check /admin/products for imported items
```

### ✅ PDF Receipt Test
```bash
# Steps:
1. Create test order
2. As admin, update status to 'delivered'
3. Check email logs for PDF attachment
4. Verify PDF content in logs
```

### ✅ Charts Test
```bash
# Steps:
1. Go to /admin/charts
2. Check browser console for errors
3. Verify charts display data
4. Test year selector
5. Test date range picker
```

### ✅ Advanced Search Test
```bash
# Steps:
1. Search "vitamin c" on homepage
2. Should find products with that ingredient
3. Search brand names
4. Search in descriptions
5. Verify relevance
```

---

## 🧪 Command Line Tests

### Test Email Configuration
```bash
php artisan tinker
>>> Mail::to('test@example.com')->send(new \App\Mail\WelcomeEmail(\App\Models\User::first()));
>>> // Check logs for email content
```

### Test PDF Generation
```bash
php artisan tinker
>>> $order = \App\Models\Order::first();
>>> $service = new \App\Services\PDFReceiptService();
>>> $pdf = $service->generateReceipt($order);
>>> // Should return PDF content
```

### Test Excel Import
```bash
php artisan tinker
>>> $import = new \App\Imports\ProductsImport();
>>> Excel::import($import, 'test-file.xlsx');
>>> // Should import without errors
```

### Test Search Functionality
```bash
php artisan tinker
>>> $results = \App\Models\Product::search('serum')->get();
>>> // Should return search results
```

---

## 📊 Test Data Creation

### Create Test Users
```bash
php artisan tinker
>>> // Admin user
>>> User::create(['name'=>'Admin', 'email'=>'admin@test.com', 'password'=>Hash::make('password'), 'role'=>'admin', 'status'=>'active', 'email_verified_at'=>now()]);

>>> // Seller user
>>> User::create(['name'=>'Seller', 'email'=>'seller@test.com', 'password'=>Hash::make('password'), 'role'=>'seller', 'status'=>'active', 'email_verified_at'=>now()]);

>>> // Customer user
>>> User::create(['name'=>'Customer', 'email'=>'customer@test.com', 'password'=>Hash::make('password'), 'role'=>'customer', 'status'=>'active', 'email_verified_at'=>now()]);
```

### Create Test Products
```bash
php artisan tinker
>>> Product::create(['name'=>'Test Serum', 'description'=>'Test description', 'brand'=>'Test Brand', 'classification'=>'Serum', 'price'=>29.99, 'quantity'=>100, 'seller_id'=>2, 'status'=>'approved']);

>>> Product::create(['name'=>'Test Moisturizer', 'description'=>'Another test', 'brand'=>'Another Brand', 'classification'=>'Moisturizer', 'price'=>39.99, 'quantity'=>50, 'seller_id'=>2, 'status'=>'approved']);
```

### Create Test Order
```bash
php artisan tinker
>>> $order = Order::create(['user_id'=>3, 'total_amount'=>69.98, 'status'=>'pending', 'payment_method'=>'cod']);
>>> OrderItem::create(['order_id'=>$order->id, 'product_id'=>1, 'price'=>29.99, 'quantity'=>1]);
>>> OrderItem::create(['order_id'=>$order->id, 'product_id'=>2, 'price'=>39.99, 'quantity'=>1]);
```

---

## 🔧 Configuration Checks

### Check Required Packages
```bash
composer show maatwebsite/excel
composer show barryvdh/laravel-dompdf
composer show laravel/scout
```

### Check Configuration Files
```bash
# Verify these files exist and are configured:
ls config/excel.php
ls config/dompdf.php
ls config/scout.php
```

### Check Mail Configuration
```bash
php artisan config:cache
php artisan tinker
>>> config('mail.default')
>>> config('mail.mailers.smtp.host')
```

---

## 🚨 Common Issues & Fixes

### Issue: Email not sending
```bash
# Fix: Configure mail settings
MAIL_MAILER=log
MAIL_LOG_CHANNEL=single
```

### Issue: PDF generation fails
```bash
# Fix: Install dompdf
composer require barryvdh/laravel-dompdf
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

### Issue: Excel import fails
```bash
# Fix: Check file permissions
chmod -R 775 storage/app/
chmod -R 775 storage/framework/
```

### Issue: Charts not loading
```bash
# Fix: Check JavaScript console
# Verify Chart.js is loading
# Check API endpoints are responding
```

---

## ✅ Success Indicators

### 🟢 All Systems Working When:
- [ ] Users can register and verify email
- [ ] Products can be created with photos
- [ ] Excel import/export works
- [ ] Search returns relevant results
- [ ] Filters work correctly
- [ ] Charts display data
- [ ] Admin can manage users
- [ ] Order emails send with PDFs
- [ ] Reviews work for purchased products
- [ ] All forms validate properly

### 🔴 Check Logs If:
- [ ] Emails not sending
- [ ] PDF generation fails
- [ ] Excel import errors
- [ ] Search not working
- [ ] Charts not displaying

---

## 📞 Quick Help Commands

```bash
# Check application status
php artisan about

# Check routes
php artisan route:list | grep -E "(admin|product|user)"

# Check logs
tail -f storage/logs/laravel.log

# Clear issues
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
```

Use this checklist to quickly verify all features are working! 🚀
