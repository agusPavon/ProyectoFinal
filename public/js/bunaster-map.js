document.addEventListener('DOMContentLoaded', function () {
  // -----------------------------
  // Variables base
  // -----------------------------
  const addCafeButton = document.getElementById('add-cafe-button');
  const suggestModalOverlay = document.getElementById('suggest-modal-overlay');
  const btnConfirmSuggest = document.getElementById('btn-confirm-suggest');
  const btnCloseSuggestModal = document.getElementById('btn-close-suggest-modal');

  const cafeModal = document.getElementById('cafe-modal');
  const reviewModal = document.getElementById('review-modal');
  const btnReviewCafe = document.getElementById('btn-review-cafe');
  const btnCloseCafeModal = document.getElementById('btn-close-cafe-modal');
  const btnCloseReviewModal = document.getElementById('btn-close-review-modal');
  const reviewFormMap = document.getElementById('reviewFormMap');
  const successMsg = document.getElementById('reviewSuccessMap');
  let activeFilters = {
    openNow: false,
    topRated: false,
    wifi: false,
    pet: false,
    music: false,
    terrace: false,
    singleOrigin: false,
    altMilk: false,
    distance: null
  };
// =========================
// FILTROS
// =========================

// Botón abrir filtros
const openFiltersBtn = document.getElementById("btn-open-filters");
const filtersModal = document.getElementById("filters-modal");
const closeFiltersBtn = document.getElementById("btn-close-filters");
const applyFiltersBtn = document.getElementById("btn-apply-filters");
const resetFiltersBtn = document.getElementById("btn-reset-filters");
const distanceSelect = document.getElementById("filter-distance");

// Activar filtros desde botones
document.querySelectorAll("[data-filter]").forEach(btn => {
    btn.addEventListener("click", () => {
        const filterKey = btn.dataset.filter;

        activeFilters[filterKey] = !activeFilters[filterKey];
        btn.classList.toggle("active");
    });
});

// Proteger cada elemento para evitar errores
if (openFiltersBtn && filtersModal) {
    openFiltersBtn.addEventListener("click", () => {
        filtersModal.classList.add("is-visible");
    });
}

if (closeFiltersBtn && filtersModal) {
    closeFiltersBtn.addEventListener("click", () => {
        filtersModal.classList.remove("is-visible");
    });
}

if (applyFiltersBtn && filtersModal) {
    applyFiltersBtn.addEventListener("click", () => {
        applyFilters();
        filtersModal.classList.remove("is-visible");
    });
}

if (resetFiltersBtn) {
    resetFiltersBtn.addEventListener("click", () => {
    activeFilters = {
        openNow: false,
        topRated: false,
        wifi: false,
        pet: false,
        terrace: false,
        singleOrigin: false,
        altMilk: false,
        distance: null
    };

    // Reset visual
    document.querySelectorAll(".filter-btn.active").forEach(b => b.classList.remove("active"));
    document.querySelectorAll("input[data-filter]").forEach(i => i.checked = false);

    distanceSelect.value = "";
    applyFilters();
});
 
}

if (distanceSelect) {
    distanceSelect.addEventListener("change", e => {
        activeFilters.distance = e.target.value || null;
    });
}





  const defaultCenter = cafes.length
    ? [cafes[0].lat, cafes[0].lng]
    : [-34.6037, -58.3816];

  // -----------------------------
  // MAPA
  // -----------------------------
  const map = L.map('map').setView(defaultCenter, 13);

  L.tileLayer(
    `https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=${MAPBOX_KEY}`,
    {
      id: 'mapbox/streets-v12',
      tileSize: 512,
      zoomOffset: -1,
      attribution: '© Mapbox © OpenStreetMap',
    }
  ).addTo(map);

  const markersGroup = L.featureGroup().addTo(map);
  const markers = {};

  cafes.forEach((c) => {
    const lat = parseFloat(c.lat);
    const lng = parseFloat(c.lng);

    if (!isNaN(lat) && !isNaN(lng)) {
      const m = L.marker([lat, lng]).addTo(markersGroup);
      m.bindPopup(`<strong>${c.name}</strong><br>${c.address || ''}`);
      markers[c.id] = m;

      // Evento click → abre modal
      m.on('click', () => showCafeModal(c));
    }
  });

  if (markersGroup.getLayers().length) {
    map.fitBounds(markersGroup.getBounds().pad(0.2));
  }

document.querySelectorAll(".cafe-card").forEach(card => {
    card.addEventListener("click", () => {
        const id = card.dataset.id;
        const cafe = cafes.find(c => c.id == id);
        if (cafe) showCafeModal(cafe);
    });
});


  // -----------------------------
  // Modal del Café
  // -----------------------------
 function showCafeModal(cafe) {
    cafeModal.querySelector('.cafe-name').innerText = cafe.name;
    cafeModal.querySelector('.cafe-address').innerText = cafe.address || '';
    cafeModal.querySelector('.cafe-rating').innerText = `⭐ ${cafe.average_rating ?? 'N/A'}`;
    cafeModal.querySelector('.cafe-description').innerText =
      cafe.description || 'Sin descripción disponible.';
    document.getElementById('reviewCafeId').value = cafe.id;

    document.getElementById('btn-checkin-cafe').onclick = () => {
        document.getElementById("checkinCafeId").value = cafe.id;
        checkinModal.classList.add("is-visible");
    };

    
    // ===============================
    // HORARIOS COMPLETOS
    // ===============================

    const openStatusEl = document.getElementById("cafe-open-status");
    const todayHoursEl = document.getElementById("cafe-today-hours");
    const weekHoursEl  = document.getElementById("cafe-week-hours");

    if (!cafe.opening_hours) {
        openStatusEl.textContent = "Horario no especificado";
        todayHoursEl.textContent = "";
        weekHoursEl.innerHTML = "";
        cafeModal.classList.add('is-visible');
        return;
    }

    // Parseo seguro
    let hours = cafe.opening_hours;
    if (typeof hours === "string") {
        try {
            hours = JSON.parse(hours);
        } catch {
            hours = {};
        }
    }

    const today = new Date().toLocaleDateString("es-AR", { weekday: "long" }).toLowerCase();

    // --- 1. Abierto ahora
    const now = new Date();
    const minsNow = now.getHours() * 60 + now.getMinutes();

    if (hours[today]) {
        const [open, close] = hours[today].split("-");
        const [h1,m1] = open.split(":").map(Number);
        const [h2,m2] = close.split(":").map(Number);

        const openM  = h1*60 + m1;
        const closeM = h2*60 + m2;

        const isOpen = minsNow >= openM && minsNow <= closeM;

        openStatusEl.textContent = isOpen ? "🟢 Abierto ahora" : "🔴 Cerrado";
    } else {
        openStatusEl.textContent = "Horario no disponible";
    }

    // --- 2. Horario de HOY
    todayHoursEl.textContent = hours[today]
        ? `Hoy: ${hours[today]}`
        : "Hoy: —";

    // --- 3. Tabla semanal
    const order = ["lunes","martes","miercoles","jueves","viernes","sabado","domingo"];

    weekHoursEl.innerHTML = `
        <strong class="text-marron-tostado">Horarios de la semana:</strong>
        <ul style="margin-top:8px; line-height: 1.4">
        ${order.map(d => `
            <li><strong>${d.charAt(0).toUpperCase()+d.slice(1)}:</strong> ${hours[d] ?? "—"}</li>
        `).join("")}
        </ul>
    `;


    cafeModal.classList.add('is-visible');
}

function renderCafeList(list) {
    const container = document.querySelector(".cafe-list-container");
    if (!container) return;

    container.innerHTML = "";

    list.forEach(cafe => {
        const div = document.createElement("div");
        div.className = "cafe-card";
        div.dataset.id = cafe.id;

        div.innerHTML = `
            <h3>${cafe.name}</h3>
            <p>${cafe.address}</p>
            <p>⭐ ${cafe.average_rating ?? "N/A"}</p>
        `;

        div.addEventListener("click", () => showCafeModal(cafe));

        container.appendChild(div);
    });
}
 


function renderMarkers(list) {
    markersGroup.clearLayers();

    list.forEach(cafe => {
        if (markers[cafe.id]) {
            markers[cafe.id].addTo(markersGroup);
        }
    });

    if (list.length) {
        map.fitBounds(markersGroup.getBounds().pad(0.2));
    }
}

function hasFeature(cafe, key) {
    if (!cafe.features) return false;

    // Si viene como array → ["wifi","pet_friendly"]
    if (Array.isArray(cafe.features)) {
        return cafe.features.includes(key);
    }

    // Si viene como objeto → { wifi: true, pet: false }
    if (typeof cafe.features === "object") {
        return cafe.features[key] === true;
    }

    return false;
}

cafes.forEach(c => {
    console.log("---- CAFE ----");
    console.log("ID:", c.id);
    console.log("FEATURES:", c.features);
    console.log("TYPE:", typeof c.features);
    console.log("IS ARRAY:", Array.isArray(c.features));
});

function applyFilters() {
    let filtered = cafes;

    // ⭐ MEJORES CALIFICADOS (4.5+)
    if (activeFilters.topRated) {
        filtered = filtered.filter(c => Number(c.average_rating) >= 4.5);
    }
// ⭐ WIFI
if (activeFilters.wifi) {
    filtered = filtered.filter(c => hasFeature(c, "wifi"));
}

// ⭐ PET FRIENDLY
if (activeFilters.pet) {
    filtered = filtered.filter(c => hasFeature(c, "pet_friendly"));
}

// ⭐ TERRAZA
if (activeFilters.terrace) {
    filtered = filtered.filter(c => hasFeature(c, "terraza"));
}

// ⭐ MÚSICA
if (activeFilters.music) {
    filtered = filtered.filter(c => hasFeature(c, "musica"));
}

// ⭐ LECHES ALTERNATIVAS
if (activeFilters.altMilk) {
    filtered = filtered.filter(c => c.milk_options?.length > 0);
}
    // // ⭐ DISTANCIA (requiere userLocation)
    // if (activeFilters.distance && userLocation) {
    //     filtered = filtered.filter(cafe => {
    //         const dist = calcularDistancia(userLocation, {
    //             lat: cafe.lat,
    //             lng: cafe.lng
    //         });

    //         return dist <= Number(activeFilters.distance);
    //     });
    // }

    // Render final
    renderMarkers(filtered);
    renderCafeList(filtered);
}






  btnCloseCafeModal.addEventListener('click', () => cafeModal.classList.remove('is-visible'));

  btnReviewCafe.addEventListener('click', () => {
    cafeModal.classList.remove('is-visible');
    reviewModal.classList.add('is-visible');
  });

  btnCloseReviewModal.addEventListener('click', () => reviewModal.classList.remove('is-visible'));

  // -----------------------------
  // Envío del formulario de reseña
  // -----------------------------
  reviewFormMap.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(reviewFormMap);
    const url = reviewFormMap.getAttribute('action');

    try {
        const response = await fetch(url, {
            method: "POST",
            headers: { "Accept": "application/json" },
            body: formData
        });

        const data = await response.json();

        // -----------------------------
        // ❌ RESEÑA REPETIDA
        // -----------------------------
        if (!response.ok || data.status === "error") {
            const errorModal = document.getElementById("review-error-modal");
            errorModal.classList.add("is-visible");
            return;
        }

        // -----------------------------
        // ✔ RESEÑA EXITOSA
        // -----------------------------
        reviewFormMap.reset();
        successMsg.classList.remove('hidden');
        successMsg.classList.add('show');

        setTimeout(() => window.location.href = "/comunidad", 1200);

    } catch (err) {
        console.error(err);
    }
});

document.getElementById("close-review-error")?.addEventListener("click", () => {
    document.getElementById("review-error-modal").classList.remove("is-visible");
});

document.getElementById("review-error-ok")?.addEventListener("click", () => {
    document.getElementById("review-error-modal").classList.remove("is-visible");
});
  // -----------------------------
  // Modal de sugerir cafetería
  // -----------------------------
  function openSuggestModal() {
    suggestModalOverlay?.classList.add('is-visible');
  }

  function closeSuggestModal() {
    suggestModalOverlay?.classList.remove('is-visible');
  }

  function handleConfirmSuggest() {
    closeSuggestModal();
    if (typeof SUGGEST_URL !== 'undefined') {
      window.location.href = SUGGEST_URL;
    }
  }

  addCafeButton?.addEventListener('click', openSuggestModal);
  btnConfirmSuggest?.addEventListener('click', handleConfirmSuggest);
  btnCloseSuggestModal?.addEventListener('click', closeSuggestModal);
 const btnCheckin      = document.getElementById("btn-checkin-cafe");
const checkinModal    = document.getElementById("checkin-modal");
const checkinCafeId   = document.getElementById("checkinCafeId");
const btnCloseCheckin = document.getElementById("btn-close-checkin-modal");

// Abrir modal de check-in
if (btnCheckin) {
    btnCheckin.addEventListener("click", () => {
        const cafeId = document.getElementById("reviewCafeId").value;
        checkinCafeId.value = cafeId;
        checkinModal.style.display = "flex";
    });
}

// Cerrar modal
if (btnCloseCheckin) {
    btnCloseCheckin.addEventListener("click", () => {
        checkinModal.style.display = "none";
    });
}

// Cerrar al tocar afuera
document.addEventListener("click", (e) => {
    if (e.target === checkinModal) {
        checkinModal.style.display = "none";
    }
});
 
const searchInput = document.getElementById("searchCafeInput");
const searchBtn   = document.getElementById("searchCafeBtn");
const bar         = document.querySelector(".search-bar-container");
const cafeCard    = document.querySelector(".cafe-card");


let searchResultsContainer = document.createElement("div");
searchResultsContainer.classList.add("search-results");

// Sólo adjuntamos si existe el contenedor
if (bar) bar.appendChild(searchResultsContainer);

function buscarCafePorNombre(nombre) {
  if (!bar) return; // por si acaso
  searchResultsContainer.innerHTML = "";
  if (!nombre || !nombre.trim()) return;

  const coincidencias = cafes.filter(cafe =>
    (cafe.name || "").toLowerCase().includes(nombre.toLowerCase())
  );

  if (coincidencias.length === 0) {
    searchResultsContainer.innerHTML = `<p class="no-results">☕ No se encontró ninguna cafetería con ese nombre.</p>`;
    return;
  }

  // 1 resultado → centrar y abrir
  if (coincidencias.length === 1) {
    const cafe = coincidencias[0];
    map.setView([cafe.lat, cafe.lng], 16);
    if (markers[cafe.id]) markers[cafe.id].openPopup();
    showCafeModal(cafe);
    searchResultsContainer.innerHTML = "";
    return;
  }

  // Varios resultados → lista
  coincidencias.forEach(cafe => {
    const item = document.createElement("div");
    item.classList.add("search-result-item");
    item.innerHTML = `
      <strong>${cafe.name}</strong><br>
      <small>${cafe.address || "Dirección no disponible"}</small>
    `;
    item.addEventListener("click", () => {
      map.setView([cafe.lat, cafe.lng], 16);
      if (markers[cafe.id]) markers[cafe.id].openPopup();
      showCafeModal(cafe);
      searchResultsContainer.innerHTML = "";
    });
    searchResultsContainer.appendChild(item);
  });
}

// Enganches solo si existen los nodos:
if (searchInput) {
  searchInput.addEventListener("keypress", (e) => {
    if (e.key === "Enter") buscarCafePorNombre(searchInput.value);
  });
}
if (searchBtn) {
  searchBtn.addEventListener("click", () => {
    buscarCafePorNombre(searchInput ? searchInput.value : "");
  });
}


// Cerrar la lista si se hace click fuera
document.addEventListener("click", (e) => {
  if (!bar) return;
  const clickedInside = bar.contains(e.target);
  if (!clickedInside) searchResultsContainer.innerHTML = "";
});


});

