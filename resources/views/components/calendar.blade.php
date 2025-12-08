<div class="space-y-3" x-data="calendarRange()">
    <label class="font-semibold block">Tanggal Kegiatan</label>
    <div class="flex flex-col md:flex-row gap-6">
        <div class="bg-gray-50 border rounded-xl p-4 flex-1">
            <div class="flex justify-between items-center mb-4">
                <button
                    @click="prevMonth()"
                    type="button"
                    class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300"
                >
                    &lt;
                </button>
                <h2
                    class="font-bold text-lg"
                    x-text="monthName() + ' ' + year"
                ></h2>
                <button
                    @click="nextMonth()"
                    type="button"
                    class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300"
                >
                    &gt;
                </button>
            </div>
            <div
                class="grid grid-cols-7 text-center font-semibold text-gray-600 mb-2 text-sm"
            >
                <template
                    x-for="d in ['Min','Sen','Sel','Rab','Kam','Jum','Sab']"
                >
                    <div x-text="d"></div>
                </template>
            </div>
            <div class="grid grid-cols-7 gap-1 text-center">
                <template x-for="day in days">
                    <div>
                        <button
                            @mousedown="startDrag(day)"
                            @mouseenter="onDragEnter(day)"
                            @mouseup="endDrag()"
                            @touchstart="startDrag(day)"
                            @touchmove.prevent="touchMove($event)"
                            @touchend="endDrag()"
                            type="button"
                            :disabled="day.disabled || !day.date"
                            :data-full="day.full ? day.full.getTime() : ''"
                            :class="[
                                'w-full py-2 rounded-lg transition text-sm',
                                day.disabled || !day.date
                                    ? 'text-gray-400 cursor-not-allowed'
                                    : 'cursor-pointer hover:bg-yellow-100',

                                day.selected
                                    ? 'bg-yellow-400 text-black font-bold'
                                    : '',

                                day.inRange
                                    ? 'bg-yellow-200 text-black'
                                    : '',
                            ]"
                            x-text="day.date"
                        ></button>
                    </div>
                </template>
            </div>
        </div>
        <div class="bg-white border rounded-xl p-6 w-full md:w-72">
            <h3 class="text-center font-bold mb-4">Waktu Acara</h3>
            <div class="mb-4">
                <label class="block text-xs font-semibold mb-1"
                    >Total Hari</label
                >
                <input
                    class="border rounded-lg p-2 w-full bg-gray-100 text-center text-sm"
                    placeholder="Total Hari"
                    x-model="totalDays"
                    readonly
                />
            </div>
            <div class="mb-4">
                <label class="block text-xs font-semibold mb-2"
                    >Dimulai Pukul</label
                >
                <div class="md:hidden mb-3">
                    <input
                        type="time"
                        class="w-full border rounded-lg p-2"
                        @input="setStartFromTimeInput($event.target.value)"
                        :value="formatTimeInput(startHour, startMinute)"
                    />
                </div>

                <div
                    class="hidden md:flex items-center justify-center gap-2 mb-3"
                >
                    <div class="flex flex-col items-center">
                        <button
                            @click="increaseStartHour()"
                            type="button"
                            class="text-yellow-500 font-bold mb-1"
                        >
                            ↑
                        </button>
                        <div class="flex flex-col gap-1">
                            <template x-for="h in getStartHourOptions()">
                                <button
                                    @click="startHour = h; notifyTimeChanged();"
                                    type="button"
                                    :class="['px-2 py-1 rounded font-semibold text-xs', startHour === h ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-700']"
                                    x-text="String(h).padStart(2, '0')"
                                ></button>
                            </template>
                        </div>
                        <button
                            @click="decreaseStartHour()"
                            type="button"
                            class="text-yellow-500 font-bold mt-1"
                        >
                            ↓
                        </button>
                    </div>
                    <div class="text-lg font-bold">:</div>
                    <div class="flex flex-col items-center">
                        <button
                            @click="increaseStartMinute()"
                            type="button"
                            class="text-yellow-500 font-bold mb-1"
                        >
                            ↑
                        </button>
                        <div class="flex flex-col gap-1">
                            <template x-for="m in getStartMinuteOptions()">
                                <button
                                    @click="startMinute = m; notifyTimeChanged();"
                                    type="button"
                                    :class="['px-2 py-1 rounded font-semibold text-xs', startMinute === m ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-700']"
                                    x-text="String(m).padStart(2, '0')"
                                ></button>
                            </template>
                        </div>
                        <button
                            @click="decreaseStartMinute()"
                            type="button"
                            class="text-yellow-500 font-bold mt-1"
                        >
                            ↓
                        </button>
                    </div>
                    <div class="flex flex-col gap-1">
                        <button
                            @click="startPeriod = 'AM'; notifyTimeChanged();"
                            type="button"
                            :class="['px-2 py-1 rounded font-semibold text-xs', startPeriod === 'AM' ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-700']"
                        >
                            AM
                        </button>
                        <button
                            @click="startPeriod = 'PM'; notifyTimeChanged();"
                            type="button"
                            :class="['px-2 py-1 rounded font-semibold text-xs', startPeriod === 'PM' ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-700']"
                        >
                            PM
                        </button>
                    </div>
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-xs font-semibold mb-2"
                    >Berakhir Pukul</label
                >
                <div class="md:hidden mb-3">
                    <input
                        type="time"
                        class="w-full border rounded-lg p-2"
                        @input="setEndFromTimeInput($event.target.value)"
                        :value="formatTimeInput(endHour, endMinute)"
                    />
                </div>

                <div class="hidden md:flex items-center justify-center gap-2">
                    <div class="flex flex-col items-center">
                        <button
                            @click="increaseEndHour()"
                            type="button"
                            class="text-yellow-500 font-bold mb-1"
                        >
                            ↑
                        </button>
                        <div class="flex flex-col gap-1">
                            <template x-for="h in getEndHourOptions()">
                                <button
                                    @click="endHour = h; notifyTimeChanged();"
                                    type="button"
                                    :class="['px-2 py-1 rounded font-semibold text-xs', endHour === h ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-700']"
                                    x-text="String(h).padStart(2, '0')"
                                ></button>
                            </template>
                        </div>
                        <button
                            @click="decreaseEndHour()"
                            type="button"
                            class="text-yellow-500 font-bold mt-1"
                        >
                            ↓
                        </button>
                    </div>
                    <div class="text-lg font-bold">:</div>
                    <div class="flex flex-col items-center">
                        <button
                            @click="increaseEndMinute()"
                            type="button"
                            class="text-yellow-500 font-bold mb-1"
                        >
                            ↑
                        </button>
                        <div class="flex flex-col gap-1">
                            <template x-for="m in getEndMinuteOptions()">
                                <button
                                    @click="endMinute = m; notifyTimeChanged();"
                                    type="button"
                                    :class="['px-2 py-1 rounded font-semibold text-xs', endMinute === m ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-700']"
                                    x-text="String(m).padStart(2, '0')"
                                ></button>
                            </template>
                        </div>
                        <button
                            @click="decreaseEndMinute()"
                            type="button"
                            class="text-yellow-500 font-bold mt-1"
                        >
                            ↓
                        </button>
                    </div>
                    <div class="flex flex-col gap-1">
                        <button
                            @click="endPeriod = 'AM'; notifyTimeChanged();"
                            type="button"
                            :class="['px-2 py-1 rounded font-semibold text-xs', endPeriod === 'AM' ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-700']"
                        >
                            AM
                        </button>
                        <button
                            @click="endPeriod = 'PM'; notifyTimeChanged();"
                            type="button"
                            :class="['px-2 py-1 rounded font-semibold text-xs', endPeriod === 'PM' ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-700']"
                        >
                            PM
                        </button>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button
                    @click="setToday()"
                    type="button"
                    class="text-yellow-500 hover:text-yellow-600 font-semibold text-sm"
                >
                    Today
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function calendarRange() {
        return {
            year: new Date().getFullYear(),
            month: new Date().getMonth(),

            startDate: null,
            endDate: null,
            totalDays: "",
            days: [],
            startHour: 10,
            startMinute: 0,
            startPeriod: "AM",
            endHour: 15,
            endMinute: 0,
            endPeriod: "PM",
            dragActive: false,
            dragJustEnded: false,
            dragStartDate: null,
            dragCurrentDate: null,

            monthName() {
                return new Date(this.year, this.month).toLocaleString("id-ID", {
                    month: "long",
                });
            },

            init() {
                const today = new Date();
                this.startDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
                this.endDate = null;
                this.totalDays = "";
                this.generateCalendar();
                setTimeout(() => {
                    this.notifyTimeChanged();
                    this.notifyDateChanged();
                }, 50);
            },

            generateCalendar() {
                const firstDay = new Date(this.year, this.month, 1).getDay();
                const totalDays = new Date(
                    this.year,
                    this.month + 1,
                    0
                ).getDate();

                let tempDays = [];
                for (let i = 0; i < firstDay; i++) {
                    tempDays.push({ date: "", disabled: true });
                }
                for (let d = 1; d <= totalDays; d++) {
                    const current = new Date(this.year, this.month, d);
                    const today = new Date();

                    const disabled =
                        current <
                        new Date(
                            today.getFullYear(),
                            today.getMonth(),
                            today.getDate()
                        );

                    let selected = false;
                    let inRange = false;

                    if (this.startDate && this.endDate) {
                        const c = current.getTime();
                        const s = this.startDate.getTime();
                        const e = this.endDate.getTime();

                        selected = c === s || c === e;
                        inRange = c > s && c < e;
                    } else if (this.startDate && !this.endDate) {
                        const s = this.startDate.getTime();
                        selected = current.getTime() === s;
                        inRange = false;
                    }

                    tempDays.push({
                        date: d,
                        full: current,
                        disabled,
                        selected,
                        inRange,
                    });
                }

                this.days = tempDays;
            },

            startDrag(day) {
                if (!day || day.disabled || !day.date) return;
                this.dragActive = true;
                this.dragStartDate = new Date(day.full);
                this.startDate = new Date(day.full);
                this.endDate = null;
                this.totalDays = "";
                this.generateCalendar();
            },

            onDragEnter(day) {
                if (!this.dragActive) return;
                if (!day || day.disabled || !day.date) return;
                this.dragCurrentDate = new Date(day.full);
                if (this.dragCurrentDate < this.dragStartDate) {
                    this.startDate = new Date(this.dragCurrentDate);
                    this.endDate = new Date(this.dragStartDate);
                } else {
                    this.startDate = new Date(this.dragStartDate);
                    this.endDate = new Date(this.dragCurrentDate);
                }
                const diff = Math.ceil((this.endDate - this.startDate) / (1000 * 60 * 60 * 24)) + 1;
                this.totalDays = diff + " hari";
                this.generateCalendar();
            },

            endDrag() {
                if (!this.dragActive) return;
                this.dragActive = false;
                this.dragJustEnded = true;
                setTimeout(() => {
                    this.dragJustEnded = false;
                }, 100);

                if (!this.endDate) {
                    if (this.startDate) {
                        this.endDate = new Date(this.startDate);
                        this.totalDays = "1 hari";
                    }
                } else {
                    const diff = Math.ceil((this.endDate - this.startDate) / (1000 * 60 * 60 * 24)) + 1;
                    this.totalDays = diff + " hari";
                }

                this.generateCalendar();
                this.notifyDateChanged();
                this.notifyTotalDaysChanged();
            },

            touchMove(evt) {
                if (!this.dragActive) return;
                const touch = evt.touches && evt.touches[0];
                if (!touch) return;
                const el = document.elementFromPoint(touch.clientX, touch.clientY);
                if (!el) return;
                const btn = el.closest('button[data-full]');
                if (!btn) return;
                const val = btn.getAttribute('data-full');
                if (!val) return;
                const t = parseInt(val, 10);
                if (isNaN(t)) return;
                const fakeDay = { full: new Date(t), date: new Date(t).getDate(), disabled: false };
                this.onDragEnter(fakeDay);
            },

            nextMonth() {
                this.month++;
                if (this.month > 11) {
                    this.month = 0;
                    this.year++;
                }
                this.generateCalendar();
            },

            prevMonth() {
                this.month--;
                if (this.month < 0) {
                    this.month = 11;
                    this.year--;
                }
                this.generateCalendar();
            },
            getStartHourOptions() {
                const hours = [];
                for (
                    let i = Math.max(0, this.startHour - 1);
                    i <= Math.min(23, this.startHour + 1);
                    i++
                ) {
                    hours.push(i);
                }
                return hours;
            },

            getStartMinuteOptions() {
                const minutes = [];
                for (
                    let i = Math.max(0, this.startMinute - 1);
                    i <= Math.min(59, this.startMinute + 1);
                    i++
                ) {
                    minutes.push(i);
                }
                return minutes;
            },

            increaseStartHour() {
                this.startHour = (this.startHour + 1) % 24;
                this.notifyTimeChanged();
            },

            decreaseStartHour() {
                this.startHour = (this.startHour - 1 + 24) % 24;
                this.notifyTimeChanged();
            },

            increaseStartMinute() {
                this.startMinute = (this.startMinute + 1) % 60;
                this.notifyTimeChanged();
            },

            decreaseStartMinute() {
                this.startMinute = (this.startMinute - 1 + 60) % 60;
                this.notifyTimeChanged();
            },
            getEndHourOptions() {
                const hours = [];
                for (
                    let i = Math.max(0, this.endHour - 1);
                    i <= Math.min(23, this.endHour + 1);
                    i++
                ) {
                    hours.push(i);
                }
                return hours;
            },

            getEndMinuteOptions() {
                const minutes = [];
                for (
                    let i = Math.max(0, this.endMinute - 1);
                    i <= Math.min(59, this.endMinute + 1);
                    i++
                ) {
                    minutes.push(i);
                }
                return minutes;
            },

            increaseEndHour() {
                this.endHour = (this.endHour + 1) % 24;
                this.notifyTimeChanged();
            },

            decreaseEndHour() {
                this.endHour = (this.endHour - 1 + 24) % 24;
                this.notifyTimeChanged();
            },

            increaseEndMinute() {
                this.endMinute = (this.endMinute + 1) % 60;
                this.notifyTimeChanged();
            },

            decreaseEndMinute() {
                this.endMinute = (this.endMinute - 1 + 60) % 60;
                this.notifyTimeChanged();
            },

            setToday() {
                const today = new Date();
                this.startDate = new Date(
                    today.getFullYear(),
                    today.getMonth(),
                    today.getDate()
                );
                this.endDate = null;
                this.totalDays = "";
                this.generateCalendar();
                this.notifyDateChanged();
            },

            formatTimeInput(hour, minute) {
                const pad = n => String((n || 0)).padStart(2, '0');
                return `${pad(hour)}:${pad(minute)}`;
            },

            setStartFromTimeInput(value) {
                if (!value) return;
                const parts = value.split(':');
                if (parts.length < 2) return;
                const hh = parseInt(parts[0], 10);
                const mm = parseInt(parts[1], 10);
                if (!isNaN(hh)) this.startHour = hh;
                if (!isNaN(mm)) this.startMinute = mm;
                this.startPeriod = (this.startHour >= 12) ? 'PM' : 'AM';
                this.notifyTimeChanged();
            },

            setEndFromTimeInput(value) {
                if (!value) return;
                const parts = value.split(':');
                if (parts.length < 2) return;
                const hh = parseInt(parts[0], 10);
                const mm = parseInt(parts[1], 10);
                if (!isNaN(hh)) this.endHour = hh;
                if (!isNaN(mm)) this.endMinute = mm;
                this.endPeriod = (this.endHour >= 12) ? 'PM' : 'AM';
                this.notifyTimeChanged();
            },

            notifyTimeChanged() {
                const pad = n => String((n || 0)).padStart(2, '0');
                const start = `${pad(this.startHour)}:${pad(this.startMinute)} ${this.startPeriod}`;
                const end = `${pad(this.endHour)}:${pad(this.endMinute)} ${this.endPeriod}`;
                document.dispatchEvent(new CustomEvent('time-changed', { detail: { start, end } }));
            },

            notifyTotalDaysChanged() {
                document.dispatchEvent(new CustomEvent('totalDays-changed', { detail: { totalDays: this.totalDays } }));
            },

            notifyDateChanged() {
                const s = this.startDate ? this.startDate.toISOString() : null;
                const e = this.endDate ? this.endDate.toISOString() : null;
                document.dispatchEvent(new CustomEvent('date-changed', { detail: { startDate: s, endDate: e } }));
            },
        };
    }
</script>
