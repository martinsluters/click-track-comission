<x-welcome-layout>
<div>
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Affiliate links performance overview (tabular) for affiliate account owner {{ $user->name }}</h1>

    <div class="mt-16 text-gray-900 dark:text-white">
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Clicks</th>
                    <th>Conversions</th>
                    <th>Conversion Ratio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statistics['labels'] as $key => $label)
                <tr>
                    <td>{{ $label }}</td>
                    <td>{{ $statistics['click_count_data'][$key] }}</td>
                    <td>{{ $statistics['conversions_count_data'][$key] }}</td>
                    <td>{{ $statistics['conversion_ratio_data'][$key] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</x-welcome-layout>
