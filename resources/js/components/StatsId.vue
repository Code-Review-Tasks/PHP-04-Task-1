<template>
    <h1>Stats by Id</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Day</th>
                <th>Total views</th>
                <th>Unique views</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="row in rows">
                <td>{{ row.day }}</td>
                <td>{{ row.total_views }}</td>                
                <td>{{ row.unique_views }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    data() {
        return {
            rows: []
        }
    },
    methods: {
        async fetchStats() {
            try {
                const response = await axios.get('/stats/' + this.$route.params.id);
                this.rows = response.data;
            } catch (e) {
                alert("Error");
            }
        }
    },
        mounted() {
            this.fetchStats()
        }
    }
</script>

<style>

</style>