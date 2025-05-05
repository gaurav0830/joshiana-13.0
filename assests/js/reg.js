document.addEventListener('DOMContentLoaded', function () {
    const degree = document.getElementById('degree');
    const department = document.getElementById('department');

    // Define the options for each category
    const options = {
        ug: [
            { value: 'BCA', text: 'BCA' },
            { value: 'BSC', text: 'BSC' }
        ],
        pg: [
            { value: 'MCA', text: 'MCA' },
            { value: 'MSC(Cs&It)', text: 'MSC(Cs&It)' }
        ]
    };

    // Function to update the second select box based on the selected category
    function updateItems() {
        const selectedDegree = degree.value;
        const items = options[selectedDegree] || [];
        
        // Clear the second select box
        department.innerHTML = '<option value="">Select Department*</option>';

        // Populate the second select box with new options
        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.value;
            option.textContent = item.text;
            department.appendChild(option);
        });
    }

    // Add event listener to the first select box
    degree.addEventListener('change', updateItems);
});

