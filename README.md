# EMI Processing Laravel Application

This project is a Laravel-based EMI (Equated Monthly Installment) processing system that dynamically calculates and manages loan repayment schedules. The application follows the **Service and Repository Pattern** for clean, modular, and maintainable code structure. It provides functionalities for storing loan details, calculating EMIs, and generating a dynamic table of EMI details, with a basic authentication system for admin access.

## Key Features:
- **Service and Repository Pattern:** The application is built using the service and repository pattern, ensuring a clean separation of concerns, better organization, and easier scalability.
- **Loan Management:** Stores loan details including client ID, number of payments, loan amount, and payment dates.
- **Dynamic EMI Calculation:** Automatically computes the monthly EMI based on loan details and stores it in a dynamically created table.
- **Admin Authentication:** Secure login system for accessing the admin dashboard to manage loan and EMI data.
- **User-Friendly Interface:** View loan and EMI details through a clean, easy-to-navigate interface.
- **Laravel Framework:** Built using the Laravel framework, ensuring robust performance and scalability.

## Installation & Setup:

1. **Unzip the Repository**

2. **Install Dependencies**
    ```bash
    composer install
    ```

3. **Set Up Environment File**
    ```bash
    cp .env.example .env
    ```

4. **Run Migrations and Seeders**
    ```bash
    php artisan migrate
    php artisan db:seed
    ```

5. **Compile Assets**
    ```bash
    npm run dev
    ```

## Admin Authentication

**Username:** developer  
**Password:** Test@Password123#

## Accessing the Application

**Login**  
Navigate to the login page and use the above credentials to access the admin dashboard.

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgements
- Laravel Documentation
- Bootstrap Documentation
