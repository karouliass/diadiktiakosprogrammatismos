function validateForm() {
    let errors = [];

    // Get form elements
    let title = document.getElementById("title").value.trim();
    let description = document.getElementById("description").value.trim();
    let year = document.getElementById("year").value;
    let copies = document.getElementById("copies").value;
    let condition = document.getElementById("condition").value;
    let categories = document.querySelectorAll('input[name="categories"]:checked');

    // Validate title
    if (!/^[a-zA-Z0-9,-]+$/.test(title)) {
        errors.push({ field: "title", message: "Title must only contain letters, numbers, commas, or hyphens." });
    }

    // Validate description
    if (description.length > 300) {
        errors.push({ field: "description", message: "Description cannot exceed 300 characters." });
    }

    // Validate year
    if (condition !== "Unknown" && (year < 1900 || year > 2024)) {
        errors.push({ field: "year", message: "Year of Publication must be between 1900 and 2024." });
    }

    // Validate copies
    if (copies <= 0) {
        errors.push({ field: "copies", message: "Number of copies must be greater than 0." });
    }

    // Validate categories
    if (categories.length > 3) {
        errors.push({ field: "categories", message: "You can select up to 3 categories." });
        alert("You can select up to 3 categories.");
    }

    // Highlight errors
    document.querySelectorAll(".error-message").forEach(el => el.remove());
    errors.forEach(error => {
        let field = document.getElementById(error.field);
        field.style.border = "2px solid red";

        let errorMsg = document.createElement("div");
        errorMsg.className = "error-message";
        errorMsg.style.color = "red";
        errorMsg.style.fontWeight = "bold";
        errorMsg.innerText = error.message;
        field.parentElement.appendChild(errorMsg);
    });

    return errors.length === 0;
}

function clearForm() {
    document.getElementById("insertBookForm").reset();

    // Reset error highlights
    document.querySelectorAll(".error-message").forEach(el => el.remove());
    document.querySelectorAll("input, textarea, select").forEach(el => el.style.border = "");
}

function handleConditionChange() {
    let condition = document.getElementById("condition").value;
    let yearField = document.getElementById("year");
    yearField.disabled = (condition === "Unknown");
}

function showTooltip(element, message) {
    let tooltip = document.createElement("div");
    tooltip.className = "tooltip-message";
    tooltip.style.position = "absolute";
    tooltip.style.backgroundColor = "#000";
    tooltip.style.color = "#fff";
    tooltip.style.padding = "5px";
    tooltip.style.borderRadius = "5px";
    tooltip.style.top = element.offsetTop - 30 + "px";
    tooltip.style.left = element.offsetLeft + "px";
    tooltip.innerText = message;
    element.parentElement.appendChild(tooltip);

    element.addEventListener("mouseout", () => {
        tooltip.remove();
    });
}