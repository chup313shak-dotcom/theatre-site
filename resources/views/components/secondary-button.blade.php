<button {{ $attributes->merge(['type' => 'button', 'class' => 'disabled:opacity-25']) }}>
    {{ $slot }}
</button>
