# GlowTrack - Visual Design Preview

## Overview
This document provides a visual description of the aesthetic and layout of each page in the GlowTrack application.

## 🎨 Design System

### Color Palette Used
```
Primary Color:     #7EC8B3  (Jade Green) - Call-to-action buttons, links
Background 1:      #F1FAF7  (Mint Cream) - Soft backgrounds
Background 2:      #CDEDE3  (Pastel Green) - Secondary backgrounds
Background 3:      #A8D5C2  (Light Sage) - Tertiary backgrounds
Accent 1:          #F6C1CC  (Blush Pink) - Highlights, decorative elements
Accent 2:          #FFD6A5  (Warm Peach) - Highlights, product cards
Text Color:        #6B4F4F  (Soft Brown) - Primary text
```

### Typography
- **Headers:** Playfair Display (elegant serif, weights: 600, 700)
- **Body:** Poppins (modern sans-serif, weights: 300-700)

## 📄 Page Descriptions

### 1. Landing Page (`/`)

#### Hero Section
- **Background:** Gradient from Mint Cream → Pastel Green → Light Sage
- **Layout:** Two-column (text left, image right on desktop; stacked on mobile)
- **Content:**
  - Large heading: "Glow Like Never Before" (Playfair Display, Soft Brown)
  - Subheading: Compelling copy about skincare journey
  - Two CTAs: "Get Started" (Jade Green button) and "Explore Products" (outlined button)
  - Trust badges: Natural, Cruelty Free, Dermatologist Tested

#### Features Section
- **Background:** White
- **Layout:** 3-column grid (responsive)
- **Cards:** Each has gradient background and hover scale effect
  - Card 1: Mint→Sage (🌿 Natural Ingredients)
  - Card 2: Blush→Peach (💎 Luxury Quality)
  - Card 3: Pastel→Sage (🎯 Results Guaranteed)

#### Products Section
- **Background:** Gradient Mint → Pastel Green
- **Layout:** 4-column grid (responsive)
- **Product Cards:**
  - Top: Emoji in colored gradient box
  - Body: Product name, description, price, "Add" button
  - Hover: Shadow increase, slight scale up

#### About Section
- **Layout:** Two-column (text left, illustration right)
- **Content:** Company story and values
- **Badges:** Established date and customer testimonial

#### CTA Section
- **Background:** Gradient Jade Green → Light Sage (dark background, white text)
- **Content:** Final call-to-action with signup/login buttons

#### Footer
- **Background:** Soft Brown (dark background, white text)
- **Layout:** 4-column footer with links
- **Content:** Company info, shop links, support, legal

---

### 2. Login Page (`/login`)

#### Design
- **Background:** Gradient Mint Cream → Pastel Green → Light Sage
- **Layout:** Centered card on the page
- **Card:** White rounded (24px radius) with shadow, 320px max width on mobile, tablet optimized

#### Header Section
- **Icon:** Large emoji (✨)
- **Title:** "Welcome Back" (Playfair Display)
- **Subtitle:** "Sign in to your GlowTrack account"

#### Form Fields
1. **Email Field**
   - Label: "Email Address"
   - Input: Mint Cream background, Light Sage border
   - On focus: Jade Green border
   - Placeholder: "your@email.com"

2. **Password Field**
   - Label: "Password"
   - Input: Mint Cream background, Light Sage border
   - On focus: Jade Green border
   - Placeholder: "••••••••"

3. **Remember Me**
   - Checkbox with Jade Green accent color
   - Text: "Remember me"

#### Buttons
- **Main Button:** Gradient Jade Green → Light Sage, full width, white text
- **Hover:** Shadow increase, slight scale up (105%)

#### Additional Elements
- **Forgot Password Link:** Jade Green text, underline on hover
- **Register Link:** Two-line layout with register link
- **Social Buttons:** Google and Apple sign-in (UI ready)
  - Layout: 2-column grid
  - Border: 2px Light Sage
  - Hover: Light Mint background

#### Trust Badge
- **Icon + Text:** 🔒 "Your data is securely encrypted and protected"
- **Styling:** Small gray text, centered below card

---

### 3. Register Page (`/register`)

#### Design
- **Background:** Gradient Mint Cream → Pastel Green → Light Sage
- **Layout:** Centered card (similar to login)
- **Card:** White rounded (24px radius) with shadow

#### Header Section
- **Icon:** Large emoji (💫)
- **Title:** "Join GlowTrack" (Playfair Display)
- **Subtitle:** "Start your skincare journey today"

#### Form Fields
1. **Full Name**
   - Mint Cream background, Light Sage border
   - On focus: Jade Green border

2. **Email Address**
   - Mint Cream background, Light Sage border
   - On focus: Jade Green border

3. **Password**
   - Mint Cream background, Light Sage border
   - Helper text: "At least 8 characters with uppercase, lowercase, and numbers"

4. **Confirm Password**
   - Mint Cream background, Light Sage border

5. **Terms & Conditions Checkbox**
   - Text includes links to Terms and Privacy Policy
   - Jade Green links

#### Buttons
- **Create Account:** Gradient Jade Green → Light Sage, full width, white text, hover effect

#### Additional Sections
- **Login Link:** "Already have an account? Sign in here"
- **Social Sign Up:** Google and Apple buttons (2-column grid)
- **Benefits Section:** 3-column layout below card
  - Welcome Bonus🎁
  - Free Shipping 🚚
  - Loyalty Points ⭐

---

### 4. Dashboard Page (`/dashboard`)

#### Welcome Section
- **Background:** White card with rounded corners
- **Layout:** Flex with emoji on right
- **Content:** Personalized greeting with user name

#### Stats Grid (3 columns)
1. **My Orders** - 📦 icon, count, link
2. **Favorites** - ❤️ icon, count, link
3. **Loyalty Points** - ⭐ icon, count, link

#### Quick Actions
- **Layout:** 4-column grid
- **Cards:** Gradient backgrounds (mint, peach, sage, jade)
- **Content:** Icon + label
- **Hover:** Shadow increase, scale effect

#### Recommended Products
- **Layout:** 4-column grid
- **Cards:** Image area with emoji, info area with Mint Cream background
- **Content:** Product name, price

---

## 🎯 Interactive Elements

### Buttons
- **Primary Button:** Jade Green background, white text, 12px rounded, hover shadow
- **Secondary Button:** Transparent with Jade Green border, hover fill
- **Hover State:** All buttons have slight scale increase (105%) and enhanced shadow

### Form Inputs
- **Default:** Light Sage border (2px), Mint Cream background
- **Focus:** Jade Green border, slight shadow
- **Error:** Red border with error message

### Cards
- **Hover:** Shadow intensifies, scale increases by 105%
- **Responsive:** Stack on mobile, 2-3 columns on tablet, 4 columns on desktop

### Navigation
- **Sticky Header:** White background, shadow, responsive menu
- **Links:** Soft Brown text, hover to Jade Green

---

## 📱 Responsive Breakpoints

- **Mobile:** < 640px (single column, stacked layout)
- **Tablet:** 640px - 1024px (2 columns, optimized spacing)
- **Desktop:** > 1024px (3-4 columns, full layout)

---

## ✨ Animation & Transitions

- **Links & Buttons:** 200ms smooth transition
- **Hover Effects:** Scale increase with shadow enhancement
- **Page Load:** Fade-in animations available
- **Scroll Behavior:** Smooth scrolling between sections

---

## 🎨 Visual Hierarchy

1. **Primary Focus:** Jade Green CTAs and main content
2. **Secondary Elements:** Light Sage and Pastel Green backgrounds
3. **Accent Elements:** Blush Pink and Warm Peach highlights
4. **Text:** Soft Brown for readability
5. **Supporting Elements:** White cards and containers

---

This design creates a cohesive, modern, and attractive skincare e-commerce experience that leverages the entire color palette while maintaining excellent readability and user experience.
