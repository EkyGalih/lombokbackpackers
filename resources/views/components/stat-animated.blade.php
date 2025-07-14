<div
    x-data="{ count: 0 }"
    x-init="
        let target = {{ $value }};
        let interval = setInterval(() => {
            if (count < target) {
                count += Math.ceil(target / 50);
                if (count > target) count = target;
            }
        }, 20);
    "
    x-text="'{{ $prefix }}' + count.toLocaleString()"
></div>

