<div class="space-y-3" x-data="calendarRange()">
    <label class="font-semibold block">Tanggal Kegiatan</label>
    <div class="flex flex-col md:flex-row gap-6">
        <div class="bg-gray-50 border rounded-xl p-4 flex-1">
            <div class="flex justify-between items-center mb-4">
                <button
                    @click="prevMonth()"
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
                            @click="selectDay(day)"
                            :disabled="day.disabled || !day.date"
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
                            class="text-yellow-500 font-bold mb-1"
                        >
                            ↑
                        </button>
                        <div class="flex flex-col gap-1">
                            <template x-for="h in getStartHourOptions()">
                                <button
                                    @click="startHour = h"
                                    :class="['px-2 py-1 rounded font-semibold text-xs', startHour === h ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-700']"
                                    x-text="String(h).padStart(2, '0')"
                                ></button>
                            </template>
                        </div>
                        <button
                            @click="decreaseStartHour()"
                            class="text-yellow-500 font-bold mt-1"
                        >
                            ↓
                        </button>
                    </div>
                    <div class="text-lg font-bold">:</div>
                    <div class="flex flex-col items-center">
                        <button
                            @click="increaseStartMinute()"
                            class="text-yellow-500 font-bold mb-1"
                        >
                            ↑
                        </button>
                        <div class="flex flex-col gap-1">
                            <template x-for="m in getStartMinuteOptions()">
                                <button
                                    @click="startMinute = m"
                                    :class="['px-2 py-1 rounded font-semibold text-xs', startMinute === m ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-700']"
                                    x-text="String(m).padStart(2, '0')"
                                ></button>
                            </template>
                        </div>
                        <button
                            @click="decreaseStartMinute()"
                            class="text-yellow-500 font-bold mt-1"
                        >
                            ↓
                        </button>
                    </div>
                    <div class="flex flex-col gap-1">
                        <button
                            @click="startPeriod = 'AM'"
                            :class="['px-2 py-1 rounded font-semibold text-xs', startPeriod === 'AM' ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-700']"
                        >
                            AM
                        </button>
                        <button
                            @click="startPeriod = 'PM'"
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
                            class="text-yellow-500 font-bold mb-1"
                        >
                            ↑
                        </button>
                        <div class="flex flex-col gap-1">
                            <template x-for="h in getEndHourOptions()">
                                <button
                                    @click="endHour = h"
                                    :class="['px-2 py-1 rounded font-semibold text-xs', endHour === h ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-700']"
                                    x-text="String(h).padStart(2, '0')"
                                ></button>
                            </template>
                        </div>
                        <button
                            @click="decreaseEndHour()"
                            class="text-yellow-500 font-bold mt-1"
                        >
                            ↓
                        </button>
                    </div>
                    <div class="text-lg font-bold">:</div>
                    <div class="flex flex-col items-center">
                        <button
                            @click="increaseEndMinute()"
                            class="text-yellow-500 font-bold mb-1"
                        >
                            ↑
                        </button>
                        <div class="flex flex-col gap-1">
                            <template x-for="m in getEndMinuteOptions()">
                                <button
                                    @click="endMinute = m"
                                    :class="['px-2 py-1 rounded font-semibold text-xs', endMinute === m ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-700']"
                                    x-text="String(m).padStart(2, '0')"
                                ></button>
                            </template>
                        </div>
                        <button
                            @click="decreaseEndMinute()"
                            class="text-yellow-500 font-bold mt-1"
                        >
                            ↓
                        </button>
                    </div>
                    <div class="flex flex-col gap-1">
                        <button
                            @click="endPeriod = 'AM'"
                            :class="['px-2 py-1 rounded font-semibold text-xs', endPeriod === 'AM' ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-700']"
                        >
                            AM
                        </button>
                        <button
                            @click="endPeriod = 'PM'"
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

            monthName() {
                return new Date(this.year, this.month).toLocaleString("id-ID", {
                    month: "long",
                });
            },

            init() {
                this.generateCalendar();
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

            selectDay(day) {
                if (day.disabled || !day.date) return;

                if (!this.startDate) {
                    this.startDate = new Date(this.year, this.month, day.date);
                    this.endDate = null;
                } else if (!this.endDate) {
                    const newEnd = new Date(this.year, this.month, day.date);
                    if (newEnd < this.startDate) {
                        this.startDate = newEnd;
                        this.endDate = null;
                        this.totalDays = "";
                    } else {
                        this.endDate = newEnd;
                        const diff =
                            Math.ceil(
                                (this.endDate - this.startDate) /
                                    (1000 * 60 * 60 * 24)
                            ) + 1;
                        this.totalDays = diff + " hari";
                    }
                } else {
                    this.startDate = new Date(this.year, this.month, day.date);
                    this.endDate = null;
                    this.totalDays = "";
                }

                this.generateCalendar();
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
            },

            decreaseStartHour() {
                this.startHour = (this.startHour - 1 + 24) % 24;
            },

            increaseStartMinute() {
                this.startMinute = (this.startMinute + 1) % 60;
            },

            decreaseStartMinute() {
                this.startMinute = (this.startMinute - 1 + 60) % 60;
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
            },

            decreaseEndHour() {
                this.endHour = (this.endHour - 1 + 24) % 24;
            },

            increaseEndMinute() {
                this.endMinute = (this.endMinute + 1) % 60;
            },

            decreaseEndMinute() {
                this.endMinute = (this.endMinute - 1 + 60) % 60;
            },

            setToday() {
                const today = new Date();
                this.startDate = new Date(
                    today.getFullYear(),
                    today.getMonth(),
                    today.getDate()
                );
                this.endDate = new Date(
                    today.getFullYear(),
                    today.getMonth(),
                    today.getDate()
                );
                this.totalDays = "1 hari";
                this.generateCalendar();
            },
        };
    }
</script>
