// JavaScript to update snack quantities
document.getElementById('popcorn-plus').addEventListener('click', function() {
    let popcornValue = parseInt(document.getElementById('popcorn').value);
    document.getElementById('popcorn').value = popcornValue + 1;
});

document.getElementById('popcorn-minus').addEventListener('click', function() {
    let popcornValue = parseInt(document.getElementById('popcorn').value);
    if (popcornValue > 0) {
        document.getElementById('popcorn').value = popcornValue - 1;
    }
});

document.getElementById('soda-plus').addEventListener('click', function() {
    let sodaValue = parseInt(document.getElementById('soda').value);
    document.getElementById('soda').value = sodaValue + 1;
});

document.getElementById('soda-minus').addEventListener('click', function() {
    let sodaValue = parseInt(document.getElementById('soda').value);
    if (sodaValue > 0) {
        document.getElementById('soda').value = sodaValue - 1;
    }
});

document.getElementById('nachos-plus').addEventListener('click', function() {
    let nachosValue = parseInt(document.getElementById('nachos').value);
    document.getElementById('nachos').value = nachosValue + 1;
});

document.getElementById('nachos-minus').addEventListener('click', function() {
    let nachosValue = parseInt(document.getElementById('nachos').value);
    if (nachosValue > 0) {
        document.getElementById('nachos').value = nachosValue - 1;
    }
});
