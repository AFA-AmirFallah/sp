<template>
    <a class="link external" href="/tikets">
        <div class="badge-top-container" role="button">
            <span :class="{ 'badge badge-primary': primary, 'badge badge-danger': !primary }">{{ TiketNo }}</span>
            <i class="i-Bell text-muted header-icon"></i>
        </div>
    </a>
</template>
<script>
import axios from 'axios';
export default {
    data() {
        return {
            TiketNo: 0,
            primary: true,

        };
    },
    mounted() {
        this.TicketCheker()
    },
    methods: {
        TicketChekerold() {

            axios.post('/tikets', {
                axios: true,
                function: 'get_open_tiket'
            }, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
                .then((response) => {
                    if (response.data > 0) {
                        this.TiketNo = response.data
                        this.primary = false
                    }

                })
        },
        TicketCheker() {
            this.TiketNo = 0
            this.primary = true

        }
    },
};

</script>