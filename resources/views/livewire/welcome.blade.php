<div>
    <div class="grid gap-5 rounded-b-xl bg-base-100 bg-base-200 p-8 md:grid-cols-4">
        <x-stat title="Messages" value="44" icon="o-envelope" tooltip="Hello" />

        <x-stat
            title="Sales"
            description="This month"
            value="22.124"
            icon="o-arrow-trending-up"
            tooltip-bottom="There"
        />

        <x-stat title="Lost" description="This month" value="34" icon="o-arrow-trending-down" tooltip-left="Ops!" />

        <x-stat
            title="Sales"
            description="This month"
            value="22.124"
            icon="o-arrow-trending-down"
            class="text-orange-500"
            color="text-pink-500"
            tooltip-right="Gosh!"
        />
    </div>

    <div>
        <div class="mockup-code">
            <pre data-prefix="$"><code>php artisan app:install</code></pre>
        </div>
    </div>
</div>
