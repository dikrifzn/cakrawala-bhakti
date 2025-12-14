@extends('layouts.app') 
@section('content')
<section class="py-20 flex flex-col justify-center items-center px-5">
    <div class="w-full max-w-5xl bg-white shadow-lg rounded-2xl p-10">
        <form method="POST" action="{{ route('booking.store') }}">
            @csrf
        <h1 class="text-3xl font-bold text-center mb-10">
            Form Pemesanan Acara
        </h1>
        <div class="mb-10">
            <h2 class="text-xl font-semibold mb-5">Data Diri</h2>

            <div class="grid grid-cols-1 gap-5">
                <input
                    type="text"
                    name="customer_name"
                    placeholder="Nama Lengkap"
                    class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-yellow-400"
                />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <input
                        type="text"
                        name="customer_phone"
                        placeholder="Nomor Telepon"
                        class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-yellow-400"
                    />

                    <input
                        type="email"
                        name="customer_email"
                        placeholder="YourEmail@gmail.com"
                        class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-yellow-400"
                    />
                </div>
            </div>
        </div>
        <div class="mb-10">
            <h2 class="text-xl font-semibold mb-5">Data Kebutuhan Acara</h2>

            <div class="grid grid-cols-1 gap-5">
                <input
                    type="text"
                    name="event_name"
                    placeholder="Nama Acara (contoh: Pernikahan Budi & Ani)"
                    class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-yellow-400"
                    required
                />
                
                <select
                    id="eventTypeSelect"
                    name="event_type_id"
                    class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-yellow-400"
                    required
                >
                    <option value="">Pilih Jenis Acara</option>
                    @foreach(App\Models\EventType::all() as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>

                <div class="grid grid-cols-1 md:grid-cols gap-5 items-start">
                    <div>
                        <x-calendar
                            label="Tanggal Acara"
                            total-id="totalHari"
                        />
                    </div>
                </div>
                <div>
                    <label class="text-sm text-gray-600 mb-2 inline-block"
                        >Lokasi Acara</label
                    >
                    <input
                        type="text"
                        name="location"
                        placeholder="Lokasi Acara"
                        class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-yellow-400"
                    />
                </div>
                <h3 class="font-semibold mt-2">Layanan yang Dibutuhkan</h3>

                <div
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 services-container"
                >
                    @forelse ($adminServices as $service)
                        @php $priceValue = $service->price ?? 0; @endphp
                        <label
                            class="service-card border rounded-xl p-5 text-center cursor-pointer transition duration-200 hover:bg-yellow-50 hover:border-yellow-400 w-full"
                            data-price="{{ $priceValue }}"
                        >
                            <input
                                type="checkbox"
                                name="services[]"
                                value="{{ $service->service_name }}|{{ $priceValue }}"
                                data-price="{{ $priceValue }}"
                                class="hidden"
                            />
                            <div class="flex flex-col items-center">
                                <span class="font-medium">{{ $service->service_name }}</span>
                                <div class="text-sm mt-2 service-price">
                                    @if($service->price && $service->price > 0)
                                        {{ "Rp ".number_format($service->price, 0, ",", ".") }}
                                    @else
                                        <span class="text-yellow-600">Menunggu admin</span>
                                    @endif
                                </div>
                            </div>
                        </label>
                    @empty
                        <div class="col-span-full text-center text-gray-500 py-4">
                            Tidak ada layanan tersedia
                        </div>
                    @endforelse
                    
                    <label
                        class="add-service-btn border-dashed border-2 rounded-xl p-5 text-center cursor-pointer transition duration-200 hover:bg-yellow-50 hover:border-yellow-400 flex items-center justify-center w-full"
                    >
                        <span class="font-semibold text-yellow-600">+ Tambahan</span>
                    </label>
                </div>
                <textarea
                    placeholder="Tulis catatan anda..."
                    class="border rounded-lg p-3 w-full h-32 mt-4 focus:ring-2 focus:ring-yellow-400"
                ></textarea>
            </div>
        </div>
        <div class="mb-10">
            <h2 class="text-xl font-semibold mb-5">Perizinan</h2>
            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-yellow-50 transition">
                <input 
                    type="checkbox" 
                    name="include_permit" 
                    id="permitCheckbox"
                    value="1"
                    class="w-5 h-5 text-yellow-500 rounded focus:ring-2 focus:ring-yellow-400"
                />
                <span class="ml-3 text-gray-700">
                    <span class="font-medium">Include Perizinan</span>
                    <p class="text-sm text-gray-500">Harga akan ditentukan oleh admin (Menunggu admin)</p>
                </span>
            </label>
        </div>
        <div class="mb-10">
            <h2 class="text-xl font-semibold mb-5">Rincian Pemesanan</h2>
                <div
                x-data="orderSummary()"
                class="bg-gray-50 border rounded-xl p-6 space-y-4"
            >
                    <input type="hidden" name="start_date" id="input_start_date">
                    <input type="hidden" name="end_date" id="input_end_date">
                    <input type="hidden" name="start_time" id="input_start_time">
                    <input type="hidden" name="end_time" id="input_end_time">
                    <input type="hidden" name="total_days" id="input_total_days">
                <div class="flex justify-between items-center pb-3 border-b">
                    <span class="text-gray-600">Nama Lengkap:</span>
                    <span class="font-semibold" x-text="fullName || '-'"></span>
                </div>
                                <div class="pt-3 border-t mt-6">
                    <div class="flex justify-between items-center pb-2">
                        <span class="text-gray-600">Nomor Telepon:</span>
                        <span
                            class="font-semibold"
                            x-text="phone || '-'"
                        ></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Email:</span>
                        <span
                            class="font-semibold text-right"
                            x-text="email || '-'"
                        ></span>
                    </div>
                </div>
                <div class="flex justify-between items-center pb-3 border-b">
                    <span class="text-gray-600">Jenis Acara:</span>
                    <span
                        class="font-semibold"
                        x-text="eventTypeName || '-'"
                    ></span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b">
                    <span class="text-gray-600">Tanggal Acara:</span>
                    <span class="font-semibold text-right">
                        <span x-show="eventStartDate && eventEndDate && eventStartDate !== eventEndDate" x-text="eventStartDate + ' s/d ' + eventEndDate"></span>
                        <span x-show="eventStartDate && eventEndDate && eventStartDate === eventEndDate" x-text="eventStartDate"></span>
                        <span x-show="!eventStartDate || !eventEndDate">-</span>
                    </span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b">
                    <span class="text-gray-600">Total Hari:</span>
                    <span
                        class="font-semibold"
                        x-text="totalDays || '-'"
                    ></span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b">
                    <span class="text-gray-600">Waktu Acara:</span>
                    <span
                        class="font-semibold"
                        x-text="eventTime || '-'"
                    ></span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b">
                    <span class="text-gray-600">Lokasi Acara:</span>
                    <span
                        class="font-semibold text-right"
                        x-text="location || '-'"
                    ></span>
                </div>
                <div class="pb-3 border-b">
                    <span class="text-gray-600">Layanan yang Dipilih:</span>
                    <div class="mt-2 space-y-1">
                        <template x-for="service in selectedServices" :key="service.name">
                            <div class="text-sm text-gray-700 flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="inline-block w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                    <span x-text="service.name"></span>
                                </div>
                                <span class="font-semibold text-right" x-text="service.pending ? 'Menunggu admin' : formatRupiah(service.price)"></span>
                            </div>
                        </template>
                        <div
                            x-show="selectedServices.length === 0"
                            class="text-sm text-gray-400"
                        >
                            Belum ada layanan yang dipilih
                        </div>
                    </div>
                </div>
                <div class="pt-3 border-t">
                    <div class="flex justify-between items-center pb-2">
                        <span class="text-gray-600">Total Harga:</span>
                        <span
                            class="font-semibold"
                            x-text="totalPrice > 0 ? formatRupiah(totalPrice) : (pendingCount > 0 ? '-' : 'Rp 0')"
                        ></span>
                    </div>

                    <div
                        x-show="pendingCount > 0"
                        class="mt-2 text-sm text-yellow-600"
                    >
                        <span x-text="pendingCount"></span> layanan menunggu
                        konfirmasi harga dari admin
                    </div>
                </div>
                <div class="pb-3">
                    <span class="text-gray-600">Catatan:</span>
                    <p
                        class="mt-2 text-sm text-gray-700"
                        x-text="notes || 'Tidak ada catatan'"
                    ></p>
                </div>
                <div class="pb-3 border-t pt-3">
                    <span class="text-gray-600">Perizinan:</span>
                    <div class="mt-2">
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="checkbox" 
                                id="permitCheckboxSummary"
                                class="w-4 h-4 text-yellow-500 rounded focus:ring-2 focus:ring-yellow-400"
                                @change="updatePermit"
                            />
                            <span class="ml-2 text-sm text-gray-700" x-text="permitIncluded ? 'Include Perizinan - Menunggu admin' : 'Tidak ada perizinan'"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
            <div class="text-right">
                <button
                    type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 transition text-white py-3 px-8 rounded-xl font-semibold shadow cursor-pointer"
                >
                    Pesan Sekarang
                </button>
            </div>
        </form>
    </div>
</section>

@endsection @push('scripts')
<script>
    const eventTypeDataMap = @json(App\Models\EventType::all()->pluck('name', 'id'));
    window.eventTypeDataGlobal = eventTypeDataMap;

    function orderSummary() {
        return {
            fullName: "",
            phone: "",
            email: "",
            eventType: "",
            eventTypeName: "",
            eventTypeData: eventTypeDataMap,
            eventDate: "",
            eventStartDate: "",
            eventEndDate: "",
            totalDays: "",
            eventTime: "",
            location: "",
            selectedServices: [],
            notes: "",
            totalPrice: 0,
            pendingCount: 0,
            pendingServices: [],
            permitIncluded: false,
            formatRupiah(value) {
                if (!value && value !== 0) return "-";
                const v = parseInt(value, 10) || 0;
                return (
                    "Rp " + v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                );
            },

            updatePermit() {
                const checkbox = document.getElementById('permitCheckbox');
                const checkboxSummary = document.getElementById('permitCheckboxSummary');
                if (checkbox) {
                    this.permitIncluded = checkbox.checked;
                    if (checkboxSummary && checkboxSummary.checked !== checkbox.checked) {
                        checkboxSummary.checked = checkbox.checked;
                    }
                }
            },

            init() {
                this.updateSummary();
                const selectEl = document.getElementById("eventTypeSelect");
                if (selectEl && selectEl.value) {
                    this.eventType = selectEl.value;
                    this.eventTypeName = this.eventTypeData[selectEl.value] || '';
                }
                this.setupListeners();
            },

            setupListeners() {
                const self = this;
                document
                    .querySelectorAll("input[placeholder='Nama Lengkap']")
                    .forEach((el) => {
                        el.addEventListener("input", () => {
                            self.fullName = el.value;
                        });
                    });
                document
                    .querySelectorAll("input[placeholder='Nomor Telepon']")
                    .forEach((el) => {
                        el.addEventListener("input", () => {
                            self.phone = el.value;
                        });
                    });
                document
                    .querySelectorAll(
                        "input[placeholder='YourEmail@gmail.com']"
                    )
                    .forEach((el) => {
                        el.addEventListener("input", () => {
                            self.email = el.value;
                        });
                    });
                document.querySelectorAll("select").forEach((el) => {
                    el.addEventListener("change", () => {
                        self.eventType = el.value;
                        // Update event type name jika ini adalah eventTypeSelect
                        if (el.id === "eventTypeSelect") {
                            self.eventTypeName = self.eventTypeData[el.value] || '';
                        }
                    });
                });

                const eventTypeSelect = document.getElementById("eventTypeSelect");
                if (eventTypeSelect) {
                    eventTypeSelect.addEventListener("change", () => {
                        self.eventType = eventTypeSelect.value;
                        self.eventTypeName = self.eventTypeData[eventTypeSelect.value] || '';
                    });
                }
                document
                    .querySelectorAll("input[placeholder='Lokasi Acara']")
                    .forEach((el) => {
                        el.addEventListener("input", () => {
                            self.location = el.value;
                        });
                    });
                document.querySelectorAll("textarea").forEach((el) => {
                    el.addEventListener("input", () => {
                        self.notes = el.value;
                    });
                });
                document.getElementById("permitCheckbox")?.addEventListener("change", () => {
                    self.updatePermit();
                });
                const permitCheckboxSummary = document.getElementById("permitCheckboxSummary");
                if (permitCheckboxSummary) {
                    permitCheckboxSummary.addEventListener("change", () => {
                        const mainCheckbox = document.getElementById("permitCheckbox");
                        if (mainCheckbox) {
                            mainCheckbox.checked = permitCheckboxSummary.checked;
                        }
                        self.updatePermit();
                    });
                }
                document.addEventListener("services-changed", () => {
                    self.updateSelectedServices();
                });

                document.addEventListener("time-changed", (e) => {
                    if (e.detail && e.detail.start && e.detail.end) {
                        self.eventTime = `${e.detail.start} - ${e.detail.end}`;
                        const elStart = document.getElementById('input_start_time');
                        const elEnd = document.getElementById('input_end_time');
                        if (elStart) elStart.value = e.detail.start;
                        if (elEnd) elEnd.value = e.detail.end;
                    }
                });

                setTimeout(() => {
                    const totalDaysInputs = document.querySelectorAll('input[placeholder="Total Hari"]');
                    totalDaysInputs.forEach(input => {
                        if (input.value) self.totalDays = input.value;
                        const syncTotalDays = () => {
                            if (input.value) self.totalDays = input.value;
                        };
                        input.addEventListener('input', syncTotalDays);
                        input.addEventListener('change', syncTotalDays);
                        const observer = new MutationObserver(syncTotalDays);
                        observer.observe(input, { attributes: true, characterData: true, subtree: true });
                    });
                }, 100);
                document.addEventListener("date-changed", (e) => {
                    if (e.detail && e.detail.startDate) {
                        const startDate = new Date(e.detail.startDate);
                        const options = { year: 'numeric', month: 'long', day: 'numeric' };
                        self.eventStartDate = startDate.toLocaleDateString('id-ID', options);
                        const iso = e.detail.startDate;
                        const el = document.getElementById('input_start_date');
                        if (el) el.value = iso;
                    }
                    if (e.detail && e.detail.endDate) {
                        const endDate = new Date(e.detail.endDate);
                        const options = { year: 'numeric', month: 'long', day: 'numeric' };
                        self.eventEndDate = endDate.toLocaleDateString('id-ID', options);
                        const iso = e.detail.endDate;
                        const el2 = document.getElementById('input_end_date');
                        if (el2) el2.value = iso;
                    }
                });

                document.addEventListener("totalDays-changed", (e) => {
                    if (e.detail && e.detail.totalDays) {
                        self.totalDays = e.detail.totalDays;
                        const el = document.getElementById('input_total_days');
                        if (el) el.value = e.detail.totalDays;
                    }
                });
            },

            updateSelectedServices() {
                const services = [];
                let total = 0;
                const pending = [];

                document
                    .querySelectorAll(
                        ".service-card input[type='checkbox']:checked"
                    )
                    .forEach((checkbox) => {
                        const rawValue = checkbox.value || "";
                        const [namePart, pricePart] = rawValue.split("|");
                        const priceAttr = checkbox.getAttribute("data-price");
                        const isPending = priceAttr === "pending" || pricePart === undefined || pricePart === "";

                        let price = 0;
                        if (!isPending) {
                            const parsed = parseInt(pricePart || priceAttr || "0", 10);
                            if (!isNaN(parsed)) {
                                price = parsed;
                                total += parsed;
                            }
                        } else {
                            pending.push(namePart);
                        }

                        services.push({
                            name: namePart,
                            price,
                            pending: isPending,
                        });
                    });

                this.selectedServices = services;
                this.totalPrice = total;
                this.pendingCount = pending.length;
                this.pendingServices = pending;
            },

            updateSummary() {
                this.updateSelectedServices();
            },
        };
    }
    (function () {
        const container = document.querySelector(".services-container");

        if (container) {
            container.addEventListener("click", (e) => {
                const addTrigger = e.target.closest(".add-service-btn");
                if (addTrigger) {
                    if (window.showCustomServiceModal)
                        window.showCustomServiceModal();
                    return;
                }

                const card = e.target.closest(".service-card");
                if (!card) return;

                const checkbox = card.querySelector("input[type='checkbox']");
                if (!checkbox) return;

                checkbox.checked = !checkbox.checked;
                if (checkbox.checked) {
                    card.classList.add(
                        "bg-yellow-500",
                        "text-white",
                        "border-yellow-600"
                    );
                } else {
                    card.classList.remove(
                        "bg-yellow-500",
                        "text-white",
                        "border-yellow-600"
                    );
                }
                document.dispatchEvent(new CustomEvent("services-changed"));
            });
        }
    })();
    (function () {
        const modalHtml = `
        <div id="customServiceModal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black opacity-40"></div>
            <div class="relative bg-white rounded-xl p-6 w-full max-w-md shadow-lg z-10 mx-auto">
                <h3 class="text-lg font-semibold mb-3">Tambah Layanan Custom</h3>
                <input id="modalCustomServiceInput" type="text" placeholder="Nama layanan (mis. Sewa Kursi)" class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-yellow-400">
                <p class="text-sm text-gray-500 mt-2">Harga akan ditentukan oleh admin (Menunggu admin).</p>
                <div class="mt-4 flex justify-end gap-3">
                    <button id="modalCancelBtn" class="px-4 py-2 rounded-lg border">Batal</button>
                    <button id="modalAddBtn" class="px-4 py-2 rounded-lg bg-yellow-500 text-white">Tambah</button>
                </div>
            </div>
        </div>`;

        document.body.insertAdjacentHTML("beforeend", modalHtml);

        const modal = document.getElementById("customServiceModal");
        const input = document.getElementById("modalCustomServiceInput");
        const cancelBtn = document.getElementById("modalCancelBtn");
        const addBtn = document.getElementById("modalAddBtn");

        function showCustomServiceModal() {
            modal.classList.remove("hidden");
            setTimeout(() => input.focus(), 50);
        }

        function hideCustomServiceModal() {
            modal.classList.add("hidden");
            input.value = "";
        }
        modal.addEventListener("click", (e) => {
            if (e.target === modal) hideCustomServiceModal();
        });

        cancelBtn.addEventListener("click", hideCustomServiceModal);

        addBtn.addEventListener("click", async () => {
            const name = input.value.trim();
            if (!name) return;

            const safeName = name.replace(/</g, "&lt;").replace(/>/g, "&gt;");
            const container = document.querySelector(".services-container");
            const label = document.createElement("label");
            label.className =
                "service-card border rounded-xl p-5 text-center cursor-pointer transition duration-200 hover:bg-yellow-50 hover:border-yellow-400";
            label.setAttribute("data-price", "pending");
            label.setAttribute("data-custom", "true");
            label.innerHTML = `
                <input type="checkbox" name="services[]" value="${safeName}" data-price="pending" data-custom="true" class="hidden" checked>
                <div class="flex flex-col items-center">
                    <span class="font-medium">${safeName}</span>
                    <div class="text-sm text-yellow-600 mt-2 service-price">Menunggu admin</div>
                    <div class="text-xs text-gray-500 mt-1 font-italic">Layanan temporary</div>
                </div>
            `;
            const addBtnCard = container.querySelector(".add-service-btn");
            if (addBtnCard) container.insertBefore(label, addBtnCard);
            else container.appendChild(label);
            label.classList.add(
                "bg-yellow-500",
                "text-white",
                "border-yellow-600"
            );
            document.dispatchEvent(new CustomEvent("services-changed"));
            hideCustomServiceModal();
        });
        input.addEventListener("keydown", (e) => {
            if (e.key === "Enter") {
                e.preventDefault();
                addBtn.click();
            }
            if (e.key === "Escape") {
                hideCustomServiceModal();
            }
        });

        window.showCustomServiceModal = showCustomServiceModal;
    })();

    // Event Type Calendar Logic
    (function() {
        const eventTypeSelect = document.getElementById('eventTypeSelect');
        
        if (eventTypeSelect) {
            eventTypeSelect.addEventListener('change', function() {
                const selectedId = this.value;
                const selectedName = eventTypeDataMap[selectedId];
                
                const calendarEl = document.querySelector('[x-data]');
                if (calendarEl && calendarEl._x_dataStack) {
                    const calendarData = calendarEl._x_dataStack[0];
                    const minDays = (selectedName === 'Pengadaan Barang') ? 7 : 14;
                    
                    calendarData.updateMinDaysOffset(minDays);
                }
            });
        }
    })();
</script>
@endpush
