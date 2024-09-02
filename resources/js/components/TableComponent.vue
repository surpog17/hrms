<template>
    <div>
        <h3>Attendance Calculation {{items[0].from}} to {{items[0].to}}</h3>
        <b-pagination
            v-model="currentPage"
            :total-rows="rows"
            :per-page="perPage"
            class="mt-4"
        >
            <template v-slot:first-text
                ><span class="text-success">First</span></template
            >
            <template v-slot:prev-text
                ><span class="text-danger">Prev</span></template
            >
            <template v-slot:next-text
                ><span class="text-warning">Next</span></template
            >
            <template v-slot:last-text
                ><span class="text-info">Last</span></template
            >
            <template v-slot:ellipsis-text>
                <b-spinner small type="grow"></b-spinner>
                <b-spinner small type="grow"></b-spinner>
                <b-spinner small type="grow"></b-spinner>
            </template>
            <template v-slot:page="{ page, active }">
                <b v-if="active">{{ page }}</b>
                <i v-else>{{ page }}</i>
            </template>
        </b-pagination>

        <p class="mt-3">Current Page: {{ currentPage }}</p>
        <b-table
            responsive
            id="calculated"
            :per-page="perPage"
            :current-page="currentPage"
            small
            striped
            hover
            :items="items"
            :fields="fields"
        ></b-table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            perPage: 10,
            currentPage: 1,
            calculated: [],
            calculate: {
                id: "",
                acc_id: "",
                name: "",
                morning_ovetime: "",
                weekend_overtime: "",
                afternoon_overtime: "",
                lunch_late: "",
                morning_late: "",
                afternoon_early: "",
                active: ""
            },
            pagination: {},
            fields: [
                { key: "acc_id", sortable: true },
                { key: "name" },
                {
                    key: "lunch_late",
                    sortable: true,
                    formatter: (value, key, item) => {
                        return (
                            Math.floor(item.lunch_late / 3600) +
                            ":" +
                            (
                                "0" +
                                (Math.floor(item.lunch_late / 60) % 60)
                            ).slice(-2) +
                            ":" +
                            ("0" + (item.lunch_late % 60)).slice(-2)
                        );
                    }
                },
                {
                    key: "morning_late",
                    sortable: true,
                    formatter: (value, key, item) => {
                        return (
                            Math.floor(item.morning_late / 3600) +
                            ":" +
                            (
                                "0" +
                                (Math.floor(item.morning_late / 60) % 60)
                            ).slice(-2) +
                            ":" +
                            ("0" + (item.morning_late % 60)).slice(-2)
                        );
                    }
                },
                {
                    key: "afternoon_early",
                    sortable: true,
                    formatter: (value, key, item) => {
                        return (
                            Math.floor(item.afternoon_early / 3600) +
                            ":" +
                            (
                                "0" +
                                (Math.floor(item.afternoon_early / 60) % 60)
                            ).slice(-2) +
                            ":" +
                            ("0" + (item.afternoon_early % 60)).slice(-2)
                        );
                    }
                },
                {
                    key: "morning_ovetime",
                    sortable: true,
                    formatter: (value, key, item) => {
                        return (
                            Math.floor(item.morning_ovetime / 3600) +
                            ":" +
                            (
                                "0" +
                                (Math.floor(item.morning_ovetime / 60) % 60)
                            ).slice(-2) +
                            ":" +
                            ("0" + (item.morning_ovetime % 60)).slice(-2)
                        );
                    }
                },
                {
                    key: "afternoon_overtime",
                    sortable: true,
                    formatter: (value, key, item) => {
                        return (
                            Math.floor(item.afternoon_overtime / 3600) +
                            ":" +
                            (
                                "0" +
                                (Math.floor(item.afternoon_overtime / 60) % 60)
                            ).slice(-2) +
                            ":" +
                            ("0" + (item.afternoon_overtime % 60)).slice(-2)
                        );
                    }
                },
                {
                    key: "weekend_overtime",
                    sortable: true,
                    formatter: (value, key, item) => {
                        return (
                            Math.floor(item.weekend_overtime / 3600) +
                            ":" +
                            (
                                "0" +
                                (Math.floor(item.weekend_overtime / 60) % 60)
                            ).slice(-2) +
                            ":" +
                            ("0" + (item.weekend_overtime % 60)).slice(-2)
                        );
                    }
                }
            ],
            items: []
        };
    },
    created() {
        this.fetchCalculated();
    },
    methods: {
        fetchCalculated() {
            fetch("/calculate")
                .then(res => res.json())
                .then(res => {
                    this.items = res.data;
                });
        }
    },
    computed: {
        rows() {
            return this.items.length;
        }
    }
};
</script>

<style scoped>
h3 {
    padding-top: 2em;
}
</style>
