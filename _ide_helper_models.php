<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $role_id
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Role|null $role
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string $message
 * @property string|null $route
 * @property int $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminNotification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class AdminNotification extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $email
 * @property string $phone
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Invoices> $invoices
 * @property-read int|null $invoices_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customers whereUserId($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\CustomersFactory factory($count = null, $state = [])
 */
	class Customers extends \Eloquent {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice_Items newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice_Items newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice_Items query()
 * @mixin \Eloquent
 * @method static \Database\Factories\Invoice_ItemsFactory factory($count = null, $state = [])
 */
	class Invoice_Items extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $customer_id
 * @property string $invoice_number
 * @property string $invoice_date
 * @property string $items
 * @property string|null $notes
 * @property string $tax_amount
 * @property string $paid_amount
 * @property string $total_amount
 * @property string $status
 * @property int $need_tax
 * @property string $currency
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customers $customer
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereInvoiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereNeedTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoices whereUserId($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\InvoicesFactory factory($count = null, $state = [])
 */
	class Invoices extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $plan_id
 * @property string $payment_method
 * @property string $amount
 * @property string $payment_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Plan $plan
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereUserId($value)
 * @mixin \Eloquent
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $price
 * @property string $type
 * @property int|null $max_invoices
 * @property int|null $max_customers
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereMaxCustomers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereMaxInvoices($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Plan extends \Eloquent {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Products newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Products newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Products query()
 * @mixin \Eloquent
 */
	class Products extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin> $admins
 * @property-read int|null $admins_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $company_name
 * @property string|null $company_email
 * @property string|null $company_phone
 * @property string|null $company_address
 * @property string|null $company_logo
 * @property string $default_currency
 * @property string|null $default_tax_rate
 * @property int $show_tax_column
 * @property int $show_email_column
 * @property string $invoice_prefix
 * @property int $start_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereCompanyAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereCompanyEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereCompanyLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereCompanyPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereDefaultCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereDefaultTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereInvoicePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereShowEmailColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereShowTaxColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereStartNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereUserId($value)
 * @mixin \Eloquent
 */
	class Settings extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $profile_pic
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int $social_login
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $plan_id
 * @property string|null $expires_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Customers> $customers
 * @property-read int|null $customers_count
 * @property-read \App\Models\UserDetail|null $detail
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Invoices> $invoices
 * @property-read int|null $invoices_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Payment> $payments
 * @property-read int|null $payments_count
 * @property-read Plan|null $plan
 * @property-read Settings|null $settings
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSocialLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string|null $address
 * @property string|null $state
 * @property string|null $zip_code
 * @property string|null $phone
 * @property string|null $calling_code
 * @property string|null $country
 * @property string|null $dp
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCallingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereDp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereZipCode($value)
 * @mixin \Eloquent
 */
	class UserDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string|null $title
 * @property string $message
 * @property string|null $route
 * @property int $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotification whereUserId($value)
 * @mixin \Eloquent
 */
	class UserNotification extends \Eloquent {}
}

