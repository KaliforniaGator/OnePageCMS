# Form Blocks

Create forms with various input types and validation.

## Basic Form

```php
echo block_form([
    'action' => '/submit',
    'method' => 'POST',
    'submit_text' => 'Send',
    'fields' => [
        [
            'type' => 'text',
            'name' => 'name',
            'label' => 'Your Name',
            'placeholder' => 'John Doe',
            'required' => true
        ],
        [
            'type' => 'email',
            'name' => 'email',
            'label' => 'Email Address',
            'placeholder' => 'john@example.com',
            'required' => true
        ]
    ]
]);
```

## Contact Form

```php
echo block_form([
    'action' => '/contact',
    'method' => 'POST',
    'submit_text' => 'Send Message',
    'fields' => [
        [
            'type' => 'text',
            'name' => 'name',
            'label' => 'Name',
            'required' => true
        ],
        [
            'type' => 'email',
            'name' => 'email',
            'label' => 'Email',
            'required' => true
        ],
        [
            'type' => 'select',
            'name' => 'subject',
            'label' => 'Subject',
            'required' => true,
            'options' => [
                '' => 'Select a subject',
                'general' => 'General Inquiry',
                'support' => 'Technical Support',
                'sales' => 'Sales Question'
            ]
        ],
        [
            'type' => 'textarea',
            'name' => 'message',
            'label' => 'Message',
            'placeholder' => 'Your message here...',
            'required' => true
        ],
        [
            'type' => 'checkbox',
            'name' => 'subscribe',
            'label' => 'Subscribe to newsletter'
        ]
    ]
]);
```

## Registration Form

```php
echo block_form([
    'action' => '/register',
    'method' => 'POST',
    'submit_text' => 'Create Account',
    'fields' => [
        [
            'type' => 'text',
            'name' => 'username',
            'label' => 'Username',
            'required' => true,
            'help' => 'Choose a unique username'
        ],
        [
            'type' => 'email',
            'name' => 'email',
            'label' => 'Email',
            'required' => true
        ],
        [
            'type' => 'password',
            'name' => 'password',
            'label' => 'Password',
            'required' => true,
            'help' => 'At least 8 characters'
        ],
        [
            'type' => 'password',
            'name' => 'confirm_password',
            'label' => 'Confirm Password',
            'required' => true
        ],
        [
            'type' => 'checkbox',
            'name' => 'terms',
            'label' => 'I agree to the Terms of Service',
            'required' => true
        ]
    ]
]);
```

## Form with Radio Buttons

```php
echo block_form([
    'action' => '/survey',
    'method' => 'POST',
    'submit_text' => 'Submit Survey',
    'fields' => [
        [
            'type' => 'radio',
            'name' => 'rating',
            'label' => 'How would you rate our service?',
            'required' => true,
            'options' => [
                '5' => 'Excellent',
                '4' => 'Good',
                '3' => 'Average',
                '2' => 'Poor',
                '1' => 'Very Poor'
            ]
        ],
        [
            'type' => 'textarea',
            'name' => 'feedback',
            'label' => 'Additional Feedback',
            'placeholder' => 'Tell us more...'
        ]
    ]
]);
```

## Field Types

### Text Input
```php
[
    'type' => 'text',
    'name' => 'field_name',
    'label' => 'Field Label',
    'placeholder' => 'Placeholder text',
    'value' => 'Default value',
    'required' => true,
    'help' => 'Help text below field'
]
```

### Email Input
```php
[
    'type' => 'email',
    'name' => 'email',
    'label' => 'Email Address',
    'required' => true
]
```

### Password Input
```php
[
    'type' => 'password',
    'name' => 'password',
    'label' => 'Password',
    'required' => true
]
```

### Textarea
```php
[
    'type' => 'textarea',
    'name' => 'message',
    'label' => 'Message',
    'placeholder' => 'Enter your message',
    'required' => false
]
```

### Select Dropdown
```php
[
    'type' => 'select',
    'name' => 'country',
    'label' => 'Country',
    'required' => true,
    'options' => [
        '' => 'Select a country',
        'us' => 'United States',
        'uk' => 'United Kingdom',
        'ca' => 'Canada'
    ]
]
```

### Checkbox
```php
[
    'type' => 'checkbox',
    'name' => 'agree',
    'label' => 'I agree to the terms',
    'value' => true,  // Pre-checked
    'required' => true
]
```

### Radio Buttons
```php
[
    'type' => 'radio',
    'name' => 'size',
    'label' => 'Select Size',
    'required' => true,
    'options' => [
        's' => 'Small',
        'm' => 'Medium',
        'l' => 'Large'
    ],
    'value' => 'm'  // Pre-selected
]
```

### Other Input Types
```php
// Number
['type' => 'number', 'name' => 'quantity', 'label' => 'Quantity']

// Date
['type' => 'date', 'name' => 'birthdate', 'label' => 'Birth Date']

// Tel
['type' => 'tel', 'name' => 'phone', 'label' => 'Phone Number']

// URL
['type' => 'url', 'name' => 'website', 'label' => 'Website']

// Hidden
['type' => 'hidden', 'name' => 'user_id', 'value' => '123']
```

## Parameters

### block_form()
- **config** (array): Form configuration
  - **action** (string): Form submission URL
  - **method** (string, default: 'POST'): HTTP method (GET/POST)
  - **fields** (array): Array of field configurations
  - **submit_text** (string, default: 'Submit'): Submit button text
  - **class** (string, optional): Additional CSS classes

### Field Configuration
- **type** (string): Input type (text, email, password, textarea, select, checkbox, radio, etc.)
- **name** (string): Field name attribute
- **label** (string): Field label
- **placeholder** (string, optional): Placeholder text
- **value** (string, optional): Default/pre-filled value
- **required** (boolean, default: false): Whether field is required
- **help** (string, optional): Help text displayed below field
- **class** (string, optional): Additional CSS classes
- **options** (array, for select/radio): Array of value => label pairs

## Examples

### Login Form
```php
echo block_form([
    'action' => '/login',
    'method' => 'POST',
    'submit_text' => 'Log In',
    'class' => 'login-form',
    'fields' => [
        ['type' => 'email', 'name' => 'email', 'label' => 'Email', 'required' => true],
        ['type' => 'password', 'name' => 'password', 'label' => 'Password', 'required' => true],
        ['type' => 'checkbox', 'name' => 'remember', 'label' => 'Remember me']
    ]
]);
```

### Order Form
```php
echo block_form([
    'action' => '/order',
    'method' => 'POST',
    'submit_text' => 'Place Order',
    'fields' => [
        ['type' => 'text', 'name' => 'name', 'label' => 'Full Name', 'required' => true],
        ['type' => 'email', 'name' => 'email', 'label' => 'Email', 'required' => true],
        ['type' => 'tel', 'name' => 'phone', 'label' => 'Phone Number', 'required' => true],
        ['type' => 'select', 'name' => 'product', 'label' => 'Product', 'required' => true, 'options' => [
            '' => 'Select a product',
            'basic' => 'Basic Plan - $9/mo',
            'pro' => 'Pro Plan - $29/mo',
            'enterprise' => 'Enterprise - Contact Us'
        ]],
        ['type' => 'number', 'name' => 'quantity', 'label' => 'Quantity', 'value' => '1', 'required' => true],
        ['type' => 'textarea', 'name' => 'notes', 'label' => 'Special Instructions', 'placeholder' => 'Any special requests?']
    ]
]);
```
