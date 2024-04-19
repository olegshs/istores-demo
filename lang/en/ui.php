<?php

return [
    'welcome' => 'Welcome',
    'register' => 'Register',
    'login' => 'Log In',
    'logout' => 'Log Out',
    'profile' => 'Profile',
    'password' => 'Password',
    'remember_me' => 'Remember me',
    'forgot_password' => 'Forgot your password?',
    'already_registered' => 'Already registered?',

    'id' => 'ID',
    'slug' => 'Slug',
    'name' => 'Name',
    'email' => 'Email',
    'description' => 'Description',
    'created_at' => 'Created at',
    'updated_at' => 'Updated at',
    'actions' => 'Actions',
    'edit' => 'Edit',
    'save' => 'Save',
    'saved' => 'Saved.',
    'delete' => 'Delete',
    'cancel' => 'Cancel',
    'total' => 'Total',

    'stores' => [
        'current' => 'Current store',
        'title' => 'Stores',
        'categories' => 'Categories',
    ],

    'dashboard' => [
        'title' => 'Dashboard',
        'logged_in' => "You're logged in!",
    ],

    'categories' => [
        'title' => 'Categories',
        'empty' => 'No categories have been created yet.',
        'create' => 'Create Category',
        'edit' => 'Edit Category #:id',
        'delete' => 'Delete Category',
        'delete_confirm' => [
            'text' => 'Are you sure you want to delete Category #:id?',
        ],
    ],

    'products' => [
        'title' => 'Products',
        'empty' => 'No products have been created yet.',
        'create' => 'Create Product',
        'edit' => 'Edit Product #:id',
        'price' => 'Price',
        'delete' => 'Delete Product',
        'delete_confirm' => [
            'text' => 'Are you sure you want to delete Product #:id?',
        ],
    ],

    'orders' => [
        'title' => 'Orders',
        'order' => 'Order #:id',
        'status' => 'Status',
        'details' => 'Details',
    ],

    'users' => [
        'title' => 'Users',
        'create' => 'Create User',
        'edit' => 'Edit User #:id',
        'roles' => 'Roles',
        'created_at' => 'Registered at',
        'switch' => 'Switch',
        'delete' => 'Delete User',
        'delete_confirm' => [
            'text' => 'Are you sure you want to delete User #:id?',
            'description' => 'Once the account is deleted, all of its resources and data will be permanently deleted.',
        ],
        'profile' => [
            'title' => 'Profile Information',
            'description' => 'Update profile information and email address.',
        ],
        'password' => [
            'title' => 'Update Password',
            'description' => 'Ensure the account is using a long, random password to stay secure.',
            'new' => 'New Password',
            'confirm' => 'Confirm Password',
        ],
    ],

    'cart' => [
        'title' => 'Cart',
        'add' => 'Add to cart',
        'open' => 'Go to cart',
        'total' => 'Total',
        'empty' => 'Your cart is empty.',
        'remove' => 'Remove',
        'close' => 'Continue shopping',
        'checkout' => 'Proceed to checkout',
    ],

    'checkout' => [
        'title' => 'Checkout',
        'details' => [
            'title' => 'Order Details',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'comment' => 'Comment',
        ],
        'pay' => [
            'title' => 'Pay',
            'card' => 'Pay with a credit card',
        ],
        'thanks' => 'Thank you!',
        'paid' => 'Order #:id has been successfully paid.',
    ],
];
