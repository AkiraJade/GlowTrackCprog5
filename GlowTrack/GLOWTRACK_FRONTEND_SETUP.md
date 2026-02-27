# GlowTrack - Skincare E-Commerce Landing Page & Auth

Beautiful, modern landing page, login, and registration pages for GlowTrack - a premium skincare e-commerce platform.

## 🎨 Color Palette

All colors have been incorporated into the design following your specifications:

- **Primary (Jade Green):** #7EC8B3
- **Mint Cream:** #F1FAF7
- **Pastel Green:** #CDEDE3
- **Light Sage:** #A8D5C2
- **Blush Pink:** #F6C1CC
- **Warm Peach:** #FFD6A5
- **Soft Brown (Text):** #6B4F4F

## 📁 Files Created

### Views
1. **`resources/views/layouts/app.blade.php`** - Main layout template with navigation and footer
2. **`resources/views/index.blade.php`** - Landing page with hero section, features, products, and CTA
3. **`resources/views/auth/login.blade.php`** - Login page
4. **`resources/views/auth/register.blade.php`** - Registration page
5. **`resources/views/dashboard.blade.php`** - User dashboard (authenticated users only)

### Controllers
1. **`app/Http/Controllers/Auth/LoginController.php`** - Handles login logic
2. **`app/Http/Controllers/Auth/RegisterController.php`** - Handles registration logic

### Configuration
1. **`tailwind.config.js`** - Tailwind configuration with custom colors and fonts
2. **`resources/css/app.css`** - Updated CSS with custom theme utilities

### Routes
Updated **`routes/web.php`** with:
- Landing page route
- Login/Register routes with auth middleware
- Logout route
- Dashboard route (protected)

## 🚀 Features

### Landing Page
- ✨ Hero section with compelling copy
- 🎯 Feature highlights with gradient cards
- 🛍️ Featured product showcase
- 📱 About section
- 🔥 Call-to-action sections
- 📱 Responsive design

### Authentication Pages
- 🔐 Secure login form
- ✍️ Registration form with validation
- 🔄 Social login buttons (UI ready)
- 💾 Password recovery link (UI ready)
- 🎨 Consistent branding and styling

### Dashboard
- 👋 Personalized welcome message
- 📊 Quick stats (Orders, Favorites, Loyalty Points)
- 🎯 Quick action buttons
- 🛒 Recommended products section

## 🛠️ Installation & Setup

### 1. Install Dependencies
```bash
npm install
composer install
```

### 2. Create Environment File
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Setup
```bash
php artisan migrate
```

### 4. Build Assets
```bash
npm run dev    # Development with hot reload
npm run build  # Production build
```

### 5. Run Server
```bash
php artisan serve
```

Visit `http://localhost:8000` to see the landing page.

## 📋 Page Routes

| Page | Route | Authentication |
|------|-------|-----------------|
| Landing Page | `/` | Public |
| Login | `/login` | Guest Only |
| Register | `/register` | Guest Only |
| Dashboard | `/dashboard` | Auth Required |

## 🎯 Design Highlights

### Typography
- **Header Font:** Playfair Display (elegant serif for headings)
- **Body Font:** Poppins (modern sans-serif)

### Components
- Gradient backgrounds using custom color palette
- Rounded cards with hover effects
- Smooth animations and transitions
- Mobile-first responsive design
- Accessibility-focused form inputs

### Color Usage
- Jade Green: Primary color for buttons and accents
- Mint/Sage tones: Backgrounds and secondary elements
- Blush Pink/Warm Peach: Accent colors for visual interest
- Soft Brown: Primary text color

## 🔐 Security

- CSRF protection on forms
- Password hashing with Laravel's built-in Hash facade
- Auth middleware for protected routes
- Email validation
- Password confirmation validation

## 📱 Responsive Design

All pages are fully responsive:
- Mobile-first approach
- Tablet optimization
- Desktop layouts
- Touch-friendly buttons and inputs

## 🔄 Next Steps

To add more features:

1. **Product Catalog** - Create a products section with filtering
2. **Shopping Cart** - Add cart functionality
3. **Checkout** - Implement payment processing
4. **User Profile** - Profile management and order history
5. **Product Reviews** - Rating and review system
6. **Admin Panel** - Product and order management

## 📞 Support

For questions or issues with the implementation, refer to:
- Laravel Documentation: https://laravel.com/docs
- Tailwind CSS: https://tailwindcss.com/docs
- Blade Templates: https://laravel.com/docs/blade

---

**GlowTrack** - Elevate Your Beauty Routine ✨
