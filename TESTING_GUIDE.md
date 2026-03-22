# 🧪 Complete Testing Guide - GlowTrack Application

## 📋 Table of Contents
1. [Environment Setup](#environment-setup)
2. [MP1: Product/Service CRUD Testing](#mp1-productservice-crud-testing)
3. [MP2: User CRUD Testing](#mp2-user-crud-testing)
4. [MP3: Authentication Testing](#mp3-authentication-testing)
5. [MP4: Product Review CRUD Testing](#mp4-product-review-crud-testing)
6. [MP5: Form Validation Testing](#mp5-form-validation-testing)
7. [MP6: Product Filtering Testing](#mp6-product-filtering-testing)
8. [MP7: Charts & Analytics Testing](#mp7-charts--analytics-testing)
9. [MP8: Search Functionality Testing](#mp8-search-functionality-testing)
10. [Term Test: Transaction Emails Testing](#term-test-transaction-emails-testing)

---

## 🔧 Environment Setup

### 1. Install Required Dependencies
```bash
# Install Excel package
composer require maatwebsite/excel

# Install PDF package
composer require barryvdh/laravel-dompdf

# Install Scout (optional - for advanced search)
composer require laravel/scout

# Publish vendor files
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

### 2. Configure Services
```bash
# Add to config/app.php providers array:
'providers' => [
    // ...
    Maatwebsite\Excel\ExcelServiceProvider::class,
    Barryvdh\DomPDF\ServiceProvider::class,
    Laravel\Scout\ScoutServiceProvider::class,
],

'aliases' => [
    // ...
    'Excel' => Maatwebsite\Excel\Facades\Excel::class,
    'PDF' => Barryvdh\DomPDF\Facades\Pdf::class,
],
```

### 3. Run Migrations
```bash
php artisan migrate
```

### 4. Create Test Data
```bash
php artisan tinker
# Create test users and products
```

---

## 📦 MP1: Product/Service CRUD Testing (20pts)

### 1. Basic CRUD Operations
**Test Steps:**
1. Login as Admin or Seller
2. Navigate to `/products/create`
3. **Create Product:**
   - Fill all required fields
   - Upload single photo
   - Submit form
   - Verify product appears in list
4. **Edit Product:**
   - Click edit on created product
   - Modify fields
   - Update photo
   - Save changes
5. **Delete Product:**
   - Click delete button
   - Confirm deletion
   - Verify product removed

**Expected Results:**
- ✅ Product creation with single photo works
- ✅ Product updates correctly
- ✅ Product deletion works
- ✅ Datatable displays products properly

### 2. Multiple Photos Upload
**Test Steps:**
1. Create new product
2. Upload multiple photos (max 5)
3. Verify all photos appear in product gallery
4. Check primary photo designation

**Expected Results:**
- ✅ Multiple photos upload successfully
- ✅ First photo set as primary
- ✅ All photos display correctly

### 3. Excel Import Functionality
**Test Steps:**
1. Navigate to `/products/import`
2. Download sample template
3. Fill template with test data:
```
name,description,brand,classification,price,size_volume,quantity,skin_types,active_ingredients
"Test Product 1","Test Description","Test Brand","Serum",29.99,"30ml",100,"Normal, Oily","Vitamin C, Hyaluronic Acid"
"Test Product 2","Another Description","Another Brand","Moisturizer",39.99,"50ml",50,"Dry, Sensitive","Ceramides, Niacinamide"
```
4. Upload the Excel file
5. Verify products are imported
6. Check product list for imported items

**Expected Results:**
- ✅ Template downloads correctly
- ✅ Excel file validates properly
- ✅ Products import with correct data
- ✅ Errors handled gracefully

---

## 👥 MP2: User CRUD Testing (20pts)

### 1. User Registration with Photo
**Test Steps:**
1. Navigate to `/register`
2. Fill registration form:
   - Name, username, email, phone, address
   - Password and confirmation
   - Upload profile photo
3. Submit registration
4. Check email for verification link
5. Click verification link
6. Try to login

**Expected Results:**
- ✅ Registration with photo works
- ✅ Email verification sent
- ✅ User can login after verification
- ✅ Profile photo displays correctly

### 2. Profile Update
**Test Steps:**
1. Login as registered user
2. Navigate to `/profile/edit`
3. Update profile information
4. Change profile photo
5. Save changes
6. Verify updates applied

**Expected Results:**
- ✅ Profile information updates
- ✅ Photo changes correctly
- ✅ Data persists after logout/login

### 3. User Management (Admin)
**Test Steps:**
1. Login as Admin
2. Navigate to `/admin/users`
3. **View Users:**
   - Verify datatable shows all users
   - Check pagination works
4. **Update User Role:**
   - Click edit on a user
   - Change role from customer to seller
   - Save changes
5. **Update User Status:**
   - Toggle user status active/inactive
   - Verify status changes
6. **Delete User:**
   - Try to delete user (should work for non-self)

**Expected Results:**
- ✅ User list displays correctly
- ✅ Role updates work
- ✅ Status updates work
- ✅ User deletion works (except self)

---

## 🔐 MP3: Authentication Testing (20pts)

### 1. Email Verification
**Test Steps:**
1. Register new user
2. Check email inbox for verification email
3. Click verification link
4. Try to login before verification (should fail)
5. Try to login after verification (should succeed)

**Expected Results:**
- ✅ Verification email sent
- ✅ Link works correctly
- ✅ Unverified users cannot login
- ✅ Verified users can login

### 2. Admin Route Protection
**Test Steps:**
1. Try to access `/admin/dashboard` as guest (should redirect)
2. Login as customer and try admin routes (should deny)
3. Login as seller and try admin routes (should deny)
4. Login as admin and access admin routes (should work)

**Expected Results:**
- ✅ Guests redirected from admin routes
- ✅ Non-admin users denied access
- ✅ Admin users can access all admin routes

---

## ⭐ MP4: Product Review CRUD Testing (20pts)

### 1. Customer Purchase Restriction
**Test Steps:**
1. Login as customer (no purchases)
2. Try to review any product (should be blocked)
3. Create test order and mark as delivered
4. Try to review purchased product (should work)

**Expected Results:**
- ✅ Non-purchasers cannot review
- ✅ Purchasers can review delivered products

### 2. Review Create/Update
**Test Steps:**
1. As eligible customer, create a review:
   - Rating (1-5 stars)
   - Comment
   - Submit
2. Edit the review:
   - Change rating
   - Update comment
   - Save
3. Verify changes applied

**Expected Results:**
- ✅ Review creation works
- ✅ Review updates work
- ✅ Changes persist correctly

### 3. Admin Review Management
**Test Steps:**
1. Login as admin
2. Navigate to product reviews section
3. View all reviews in datatable
4. Delete inappropriate review
5. Verify review removed

**Expected Results:**
- ✅ Reviews display in datatable
- ✅ Admin can delete reviews
- ✅ Review deletion works

---

## ✅ MP5: Form Validation Testing (15pts)

### 1. Product Form Validation
**Test Steps:**
1. Create product with invalid data:
   - Empty name
   - Invalid price (negative, text)
   - Invalid classification
   - Invalid file type
   - Oversized file
2. Submit form
3. Check error messages

**Expected Results:**
- ✅ Required field validation works
- ✅ Data type validation works
- ✅ File validation works
- ✅ Error messages display correctly

### 2. User Registration Validation
**Test Steps:**
1. Register with invalid data:
   - Duplicate email/username
   - Weak password
   - Invalid email format
   - Missing required fields
2. Submit form
3. Check error messages

**Expected Results:**
- ✅ All validation rules work
- ✅ Clear error messages
- ✅ Form preserves input on errors

---

## 🔍 MP6: Product Filtering Testing (15pts)

### 1. Price Filtering
**Test Steps:**
1. Navigate to products page
2. Set min price filter
3. Set max price filter
4. Verify results match price range
5. Test edge cases

**Expected Results:**
- ✅ Min price filter works
- ✅ Max price filter works
- ✅ Combined price range works

### 2. Category/Brand/Type Filtering
**Test Steps:**
1. Filter by classification (cleanser, moisturizer, etc.)
2. Filter by brand
3. Filter by skin type
4. Combine multiple filters
5. Verify results match all criteria

**Expected Results:**
- ✅ Individual filters work
- ✅ Combined filters work
- ✅ Filter combinations accurate

---

## 📊 MP7: Charts & Analytics Testing (15pts)

### 1. Yearly Sales Chart
**Test Steps:**
1. Login as admin
2. Navigate to `/admin/charts`
3. Select different years
4. Verify chart updates
5. Check data accuracy

**Expected Results:**
- ✅ Chart displays yearly data
- ✅ Year selector works
- ✅ Data is accurate

### 2. Date Range Charts
**Test Steps:**
1. Set custom date range
2. Click "Update Chart"
3. Verify chart shows correct period
4. Test different date combinations

**Expected Results:**
- ✅ Date range selection works
- ✅ Chart updates correctly
- ✅ Data matches selected period

### 3. Pie Charts
**Test Steps:**
1. View product sales pie chart
2. Check percentage calculations
3. View category distribution chart
4. Verify data accuracy

**Expected Results:**
- ✅ Pie charts display correctly
- ✅ Percentages calculated accurately
- ✅ Interactive tooltips work

---

## 🔎 MP8: Search Functionality Testing (15pts)

### 1. LIKE Query Search
**Test Steps:**
1. Use homepage search bar
2. Search by product name
3. Search by brand
4. Search by description keywords
5. Verify results relevance

**Expected Results:**
- ✅ Name search works
- ✅ Brand search works
- ✅ Description search works
- ✅ Results are relevant

### 2. Advanced Search (Scout)
**Test Steps:**
1. Search for complex terms
2. Search ingredients
3. Search skin types
4. Test partial matches
5. Verify fallback to LIKE if Scout fails

**Expected Results:**
- ✅ Advanced search works
- ✅ Ingredient search works
- ✅ Graceful fallback works

---

## 📧 Term Test: Transaction Emails Testing (30pts)

### 1. Order Confirmation Email
**Test Steps:**
1. Place test order as customer
2. Check email inbox
3. Verify email contains:
   - Order details
   - Product list
   - Total amount
   - PDF receipt attachment
4. Download and open PDF receipt
5. Verify PDF content and formatting

**Expected Results:**
- ✅ Email sent immediately
- ✅ All order details present
- ✅ PDF attachment works
- ✅ PDF formatting correct

### 2. Order Status Updates
**Test Steps:**
1. As admin, update order status
2. Check customer email for notification
3. Verify email shows:
   - Previous status
   - New status
   - Timeline information
4. Test different status changes
5. For delivered orders, check PDF attachment

**Expected Results:**
- ✅ Email sent on status change
- ✅ Status information accurate
- ✅ Timeline displays correctly
- ✅ PDF attached for delivered orders

### 3. PDF Receipt Quality
**Test Steps:**
1. Generate multiple receipts
2. Check PDF formatting
3. Verify all order details included
4. Test with different order sizes
5. Verify professional appearance

**Expected Results:**
- ✅ Professional layout
- ✅ All data included
- ✅ Consistent formatting
- ✅ Download works correctly

---

## 🚀 Automated Testing Commands

### Run All Tests
```bash
# Run feature tests
php artisan test

# Run specific test files
php artisan test tests/Feature/ProductTest.php
php artisan test tests/Feature/UserTest.php
php artisan test tests/Feature/OrderTest.php

# Generate test coverage report
php artisan test --coverage
```

### Database Testing
```bash
# Refresh database with seeds
php artisan migrate:fresh --seed

# Create test data
php artisan db:seed --class=TestDataSeeder
```

### Email Testing (Local)
```bash
# Configure mail settings for testing
MAIL_MAILER=log
MAIL_LOG_CHANNEL=single

# Check email logs
tail -f storage/logs/laravel.log
```

---

## 📝 Testing Checklist

### Before Testing:
- [ ] All dependencies installed
- [ ] Database migrated
- [ ] Test data created
- [ ] Email configured for testing

### During Testing:
- [ ] Each feature tested individually
- [ ] Error scenarios tested
- [ ] Edge cases covered
- [ ] Cross-browser compatibility checked

### After Testing:
- [ ] All tests pass
- [ ] No critical bugs found
- [ ] Performance acceptable
- [ ] Security verified

---

## 🔧 Debugging Tips

### Common Issues:
1. **Email not sending**: Check mail configuration
2. **PDF generation fails**: Verify dompdf installation
3. **Excel import errors**: Check file permissions and format
4. **Search not working**: Verify Scout configuration
5. **Charts not displaying**: Check JavaScript console

### Debug Commands:
```bash
# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Check logs
tail -f storage/logs/laravel.log

# Debug email
php artisan tinker
Mail::to('test@example.com')->send(new TestMail());
```

---

## ✅ Success Criteria

Each feature is considered working when:
- ✅ All test steps complete successfully
- ✅ No errors in logs
- ✅ Expected results match actual results
- ✅ User experience is smooth
- ✅ Data integrity maintained

Run through this comprehensive testing guide to verify all 135 points are working correctly!
