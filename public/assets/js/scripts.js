document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("changePasswordForm");
    if (form) {
        form.addEventListener("submit", function (event) {
            const oldPassword = document.getElementById("old_pass");
            const newPassword = document.getElementById("new_pass");
            const confirmPassword = document.getElementById("confirm_pass");

            newPassword.classList.remove("is-invalid");
            confirmPassword.classList.remove("is-invalid");

            let isValid = true;

            if (newPassword.value !== confirmPassword.value) {
                confirmPassword.classList.add("is-invalid");
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    }

    const selectEl = document.getElementById("therapeutic_areas_select");
    const inputWrapper = document.getElementById("medication_input_wrapper");

    if (selectEl && inputWrapper) {
        selectEl.addEventListener("change", function () {
            const selectedValue = this.value;

            if (selectedValue === "2") {
                inputWrapper.style.display = "block";
            } else {
                inputWrapper.style.display = "none";
            }
        });

        selectEl.dispatchEvent(new Event("change"));
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const doctorSearch = document.getElementById("doctor-search");
    const box = document.getElementById("search-suggestions");
    let input =
        document.querySelector('.search-bar input[type="text"]') ||
        document.querySelector('.search-container input[type="text"]');

    if (!doctorSearch || !box || !input) {
        console.warn(
            "Doctor search input or suggestion box not found in the DOM."
        );
        return;
    }

    doctorSearch.addEventListener("input", function () {
        const query = this.value.trim();

        if (query.length === 0) {
            if (box) {
                box.style.display = "none";
                box.innerHTML = "";
            }
            input.classList.remove("rounded-top");
            return;
        }

        if (query.length < 2) {
            if (box) {
                box.style.display = "none";
            }
            return;
        }

        fetch(route("doctor.search", { q: query }))
            .then((res) => res.json())
            .then((data) => {
                box.innerHTML = "";

                if (data.length === 0) {
                    box.innerHTML = `<div style="padding: 8px;">${noResult}</div>`;
                    input.classList.add("rounded-top");
                } else {
                    input.classList.add("rounded-top");

                    data.forEach((doctor, index) => {
                        const div = document.createElement("div");
                        div.textContent = doctor.first_name;
                        div.style.padding = "5px";
                        div.style.borderBottom = "1px solid #ccc";
                        div.style.cursor = "pointer";
                        div.style.transition = "background-color 0.2s ease";

                        div.addEventListener("mouseenter", () => {
                            div.style.backgroundColor = "#e4e3e3";
                            div.style.borderRadius = "20px";
                        });

                        div.addEventListener("mouseleave", () => {
                            div.style.backgroundColor = "";
                            div.style.borderRadius = "";
                        });

                        if (index === data.length - 1) {
                            div.style.borderBottom = "none";
                        }

                        div.addEventListener("click", () => {
                            window.location.href = route("doctor.show", {
                                doctor: doctor.id,
                            });
                        });
                        box.appendChild(div);
                    });
                }

                if (box) {
                    box.style.display = "block";
                }
            })
            .catch((err) => {
                console.error("Error fetching doctors:", err);
            });
    });

    document.addEventListener("click", function (e) {
        if (box && doctorSearch && !doctorSearch.contains(e.target) && !box.contains(e.target)) {
            box.style.display = "none";
            box.innerHTML = "";
            input.classList.remove("rounded-top");
        }
    });
});

/*document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme');

    if (!savedTheme) {
        showPopup();
    } else {
        applyTheme(savedTheme);
    }
});

function applyTheme(theme) {
    const themeStyle = document.getElementById('theme-style');
    const kidsStyle = document.getElementById('kids-style');

    if (theme === 'kids') {
        themeStyle.disabled = true;
        kidsStyle.disabled = false;
        document.title = `${samaaKidsTitle}`;
    } else {
        themeStyle.disabled = false;
        kidsStyle.disabled = true;
        document.title = `${samaaTitle}`;
    }

    localStorage.setItem('theme', theme);
}

function showPopup() {
    document.getElementById('theme-popup').classList.add('active');
    document.getElementById('overlay').classList.add('active');
}

function closePopup() {
    document.getElementById('theme-popup').classList.remove('active');
    document.getElementById('overlay').classList.remove('active');
}

document.getElementById('default-theme-btn').addEventListener('click', () => {
    applyTheme('default');
    closePopup();
});

document.getElementById('kids-theme-btn').addEventListener('click', () => {
    applyTheme('kids');
    closePopup();
});*/

document.addEventListener("DOMContentLoaded", function () {
    const themeOverrideStyle = document.getElementById("theme-override-style");
    const kidsOverridePath = themeOverrideStyle?.dataset.kidsPath;
    const defaultBtn = document.getElementById("default-theme-btn");
    const kidsBtn = document.getElementById("kids-theme-btn");
    const popup = document.getElementById("theme-popup");
    const overlay = document.getElementById("overlay");

    const savedTheme = localStorage.getItem("theme");
    console.log("Saved theme:", savedTheme);

    if (savedTheme === "kids" && themeOverrideStyle) {
        console.log("Applying kids theme override", kidsOverridePath);
        themeOverrideStyle.href = kidsOverridePath;
    }

    if (defaultBtn) {
        defaultBtn.addEventListener("click", () => {
            localStorage.setItem("theme", "default");
            if (themeOverrideStyle) themeOverrideStyle.removeAttribute("href");
            closeThemePopup();
        });
    }

    if (kidsBtn) {
        kidsBtn.addEventListener("click", () => {
            localStorage.setItem("theme", "kids");
            if (themeOverrideStyle) themeOverrideStyle.href = kidsOverridePath;
            closeThemePopup();
        });
    }

    if (!localStorage.getItem("themeSelectedOnce")) {
        if (popup) popup.style.display = "block";
        if (overlay) overlay.style.display = "block";
        localStorage.setItem("themeSelectedOnce", "true");
    }

    function closeThemePopup() {
        if (popup) popup.style.display = "none";
        if (overlay) overlay.style.display = "none";
    }
});

$(document).ready(function () {
    $(".diseases-select").select2({
        placeholder: "{{ __('site.Select one or more diseases') }}",
        /*allowClear: true,*/
        width: "100%",
    });
});
