<!--
This is how to declare a prop to distinguish them from attributes.
Both props and attributes are passed in via attributes of a blade tag.
Access attributes via $attributes
Access props via the variable name used for the prop. 
Note when passing in a prop in a blade tag prefix it with a colon ":" if you want anything between the quotes to be treated as an expression
-->
@props(['active' => false])

<a
    class="{{ $active ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium"
    aria-current="{{ $active ? 'page' : 'false' }}" {{ $attributes }}>
    {{ $slot }}
</a>