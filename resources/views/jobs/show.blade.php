<x-layout>
    <x-slot:heading>Job</x-slot-heading>

        <h2 class="font-bold text-lg">{{ $job['title'] }}</h2>
        <p>This job pays {{ $job['salary'] }} per year.</p>

        <!-- this is a GATE -->
        @can('edit-job', $job) <!-- using a GATE to hid and show the edit button if user is authorized via the gate-->
        <p><x-button href="/jobs/{{ $job['id'] }}/edit">Edit Job</x-button></p>
        @endcan <!-- this is now replaced because we updated to using policeis as shown below. This remains for cocumentation purposes -->

        <!-- this is a POLICY. It does the same thing as the GATE above -->
        @can('edit', $job) <!-- using a POLICY to hid and show the edit button if user is authorized via the gate-->
        <p><x-button href="/jobs/{{ $job['id'] }}/edit">Edit Job</x-button></p>
        @endcan
</x-layout>