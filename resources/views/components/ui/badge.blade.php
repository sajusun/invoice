@props([
    'status' => 'pending',
    'size'   => 'md', // sm, md
])

@php
    $normalized = strtolower(trim((string) $status));

    $config = match($normalized) {
        'paid', 'active', 'success', 'verified' => [
            'label' => ucfirst($normalized),
            'dot'   => 'bg-emerald-500',
            'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        ],
        'unpaid', 'pending', 'draft' => [
            'label' => ucfirst($normalized),
            'dot'   => 'bg-amber-500',
            'class' => 'bg-amber-50 text-amber-700 border-amber-200',
        ],
        'overdue', 'failed', 'canceled', 'cancelled', 'revoked', 'unverified' => [
            'label' => ucfirst($normalized),
            'dot'   => 'bg-rose-500',
            'class' => 'bg-rose-50 text-rose-700 border-rose-200',
        ],
        'free' => [
            'label' => 'Free Tier',
            'dot'   => 'bg-gray-400',
            'class' => 'bg-gray-100 text-gray-700 border-gray-200',
        ],
        'premium' => [
            'label' => 'Premium',
            'dot'   => 'bg-blue-500',
            'class' => 'bg-blue-50 text-blue-700 border-blue-200',
        ],
        'business', 'enterprise' => [
            'label' => 'Business',
            'dot'   => 'bg-purple-500',
            'class' => 'bg-purple-50 text-purple-700 border-purple-200',
        ],
        'super_admin' => [
            'label' => 'Super Admin',
            'dot'   => 'bg-indigo-600',
            'class' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
        ],
        'admin' => [
            'label' => 'Admin',
            'dot'   => 'bg-blue-600',
            'class' => 'bg-blue-50 text-blue-700 border-blue-200',
        ],
        'moderator' => [
            'label' => 'Moderator',
            'dot'   => 'bg-teal-600',
            'class' => 'bg-teal-50 text-teal-700 border-teal-200',
        ],
        default => [
            'label' => ucfirst($normalized),
            'dot'   => 'bg-gray-400',
            'class' => 'bg-gray-50 text-gray-700 border-gray-200',
        ],
    };

    $sizeClasses = $size === 'sm' ? 'px-2 py-0.5 text-[11px]' : 'px-2.5 py-1 text-xs';
@endphp

<span class="inline-flex items-center gap-1.5 font-medium rounded-full border {{ $config['class'] }} {{ $sizeClasses }}">
    <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }}"></span>
    {{ $config['label'] }}
</span>
