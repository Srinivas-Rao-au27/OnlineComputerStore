# Online Computer Store

A complete e-commerce web application for selling computers, laptops, and accessories. Built with PHP, MySQL, and Bootstrap.

## 🚀 Features

### Customer Features
- **Product Browsing**: View all products with images, descriptions, and prices
- **Product Details**: Detailed view of individual products
- **Shopping Cart**: Add, update, and remove items from cart
- **User Registration/Login**: Secure user authentication system
- **Checkout Process**: Complete purchase workflow
- **Responsive Design**: Mobile-friendly interface

### Admin Features
- **Admin Dashboard**: Manage products, orders, and users
- **Product Management**: Add, edit, and delete products
- **Order Management**: View and manage customer orders
- **User Management**: Monitor registered users
- **Secure Admin Login**: Protected admin area

### Technical Features
- **Database Integration**: MySQL database with proper relationships
- **Session Management**: Secure user sessions
- **Input Validation**: Form validation and sanitization
- **Responsive UI**: Bootstrap 5 for modern design
- **Font Awesome Icons**: Professional iconography

## 📋 Prerequisites

Before running this project, make sure you have:

- **XAMPP** (Apache + MySQL + PHP)
- **PHP 7.4+** 
- **MySQL 5.7+**
- **Web Browser** (Chrome, Firefox, Safari, Edge)

## 🛠️ Installation & Setup

### Step 1: Download/Clone the Project

```bash
# Clone the repository
git clone https://github.com/Srinivas-Rao-au27/Online-Computer-Store.git

# Or download and extract the ZIP file
# Place the project in your XAMPP htdocs folder
```

### Step 2: Start XAMPP Services

1. Open **XAMPP Control Panel**
2. Start **Apache** (click "Start" button)
3. Start **MySQL** (click "Start" button)
4. Ensure both services show **green status**

### Step 3: Database Setup

1. **Open phpMyAdmin**: Go to `http://localhost/phpmyadmin`
2. **Create Database**: 
   - Click "New" in the left sidebar
   - Enter database name: `computer_store`
   - Click "Create"

3. **Import Database Schema**:
   - Select the `computer_store` database
   - Click "Import" tab
   - Choose file: `database.sql`
   - Click "Go" to import

### Step 4: Configure Database Connection

1. Open `includes/db_connect.php`
2. Verify the database credentials:
   ```php
   $host = 'localhost';
   $port = 3306;
   $user = 'root';
   $pass = '';
   $db = 'computer_store';
   ```

### Step 5: Test the Setup

1. **Test Database Connection**: 
   - Visit: `http://localhost/online-computer-store/check_database.php`
   - Should show "✅ MySQL Connection Successful!"

2. **Test Main Page**:
   - Visit: `http://localhost/online-computer-store/`
   - Should display the homepage

## 📁 Project Structure

```
online-computer-store/
├── admin/                    # Admin panel files
│   ├── admin_login.php      # Admin login page
│   ├── dashboard.php        # Admin dashboard
│   ├── add_product.php      # Add new products
│   ├── manage_products.php  # Manage existing products
│   └── view_orders.php      # View customer orders
├── includes/                # Shared components
│   ├── head.php            # HTML head section
│   ├── header.php          # Navigation bar
│   ├── footer.php          # Footer section
│   └── db_connect.php      # Database connection
├── css/                    # Stylesheets
│   └── style.css           # Custom CSS
├── js/                     # JavaScript files
│   └── script.js           # Custom JavaScript
├── images/                 # Product images
├── index.php               # Homepage
├── products.php            # Product listing
├── product.php             # Individual product view
├── cart.php                # Shopping cart
├── checkout.php            # Checkout process
├── login.php               # User login
├── register.php            # User registration
├── logout.php              # User logout
├── database.sql            # Database schema
├── setup_database.php      # Database setup script
├── check_database.php      # Database connection test
└── README.md               # This file
```

## 🗄️ Database Schema

### Main Tables

- **users**: User accounts and authentication
- **products**: Product catalog with images and details
- **user_cart**: Shopping cart items for each user
- **orders**: Customer orders and order details
- **admin_users**: Admin authentication

### Key Relationships

- Users can have multiple cart items
- Users can have multiple orders
- Products can be in multiple carts
- Orders contain multiple order items

## 👥 User Roles

### Customer
- Browse products
- Add items to cart
- Complete purchases
- View order history

### Admin
- Manage product catalog
- View all orders
- Monitor user activity
- Add/edit products

## 🎨 Customization

### Styling
- Edit `css/style.css` for custom styles
- Modify Bootstrap classes in PHP files
- Update color scheme and fonts

### Content
- Add products via admin panel
- Update product images in `images/` folder
- Modify text content in PHP files

### Features
- Add new pages by following the existing structure
- Extend database schema as needed
- Add new admin functions

## 🔧 Troubleshooting

### Common Issues

1. **"Target machine actively refused it" Error**
   - **Solution**: Start MySQL in XAMPP Control Panel

2. **Database connection failed**
   - **Solution**: Check database credentials in `includes/db_connect.php`

3. **Page not loading**
   - **Solution**: Ensure Apache is running in XAMPP

4. **Images not displaying**
   - **Solution**: Check image paths and file permissions

5. **Admin login not working**
   - **Solution**: Import the database schema properly

### Testing Tools

- **Database Test**: `http://localhost/online-computer-store/check_database.php`
- **Setup Database**: `http://localhost/online-computer-store/setup_database.php`
- **Test Page**: `http://localhost/online-computer-store/test_page.php`

## 🚀 Deployment

### Local Development
- Use XAMPP for local development
- Access via `http://localhost/online-computer-store/`

### Production Deployment
1. Upload files to web server
2. Configure database on hosting provider
3. Update database credentials in `includes/db_connect.php`
4. Set proper file permissions
5. Configure domain and SSL

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📞 Support

If you encounter any issues:

1. Check the troubleshooting section above
2. Verify XAMPP services are running
3. Test database connection
4. Check error logs in XAMPP

## 🎯 Features Roadmap

- [ ] Payment gateway integration
- [ ] Email notifications
- [ ] Product reviews and ratings
- [ ] Advanced search and filtering
- [ ] Inventory management
- [ ] Sales analytics
- [ ] Mobile app version

---

**Built with ❤️ using PHP, MySQL, and Bootstrap**


student name and ID 
Abinidhi Srinivas Rao 249426560
bharti panwar 
mohit 
prachi

