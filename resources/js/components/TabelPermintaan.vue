<script setup>
    import { ref, onMounted, reactive, watch } from "vue";
    import {formatDateString} from "@/vendor/moment";
    
    // emit
    const emit = defineEmits(['close-modal'])

    const props = defineProps(['permintaan']);

    let dataPermintaan = reactive()
    const formatDate = (value) => {
        return formatDateString(value, "DD MMMM YYYY HH:mm");
    }

    const closeModal = () => {
        emit('close-modal')
    }

    onMounted(() => {
    });

    watch(() => {
        dataPermintaan = props.permintaan;
    });
</script>


<template>
    <div class="card border-0 rounded shadow">
        <div class="card-body">
            <div class="table-responsive" v-if="dataPermintaan.staff_nik !== undefined" >
                
                <table class="table table-dark table-striped-columns">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center">REVIEW PERMINTAAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr >
                            <td width="200">NIK Peminta</td>
                            <td>{{ dataPermintaan.staff_nik }}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>{{ dataPermintaan.staff.nama }}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>{{ dataPermintaan.staff.departemen.nama }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Permintaan</td>
                            <td>{{ formatDate(dataPermintaan.tanggal_permintaan) }}</td>
                        </tr>
                    </tbody>
                </table>
                
                 <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                            <th colspan="7" class="text-center">DETAIL PERMINTAAN BARANG</th>
                        </tr>
                        <tr>
                            <th align="center">No</th>
                            <th align="center">Barang</th>
                            <th align="center">Lokasi</th>
                            <th align="center">Kuantiti</th>
                            <th align="center">Satuan</th>
                            <th align="center">Keterangan</th>
                            <th align="center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(detail, index) in dataPermintaan.details" :key="index">
                            <td align="center">{{ index + 1 }}</td>
                            <td>{{ detail.barang.code }} - {{ detail.barang.nama }}</td>
                            <td>{{ detail.barang.lokasi.nama }}</td>
                            <td align="center">{{ detail.kuantiti }}</td>
                            <td align="center">{{ detail.barang.satuan }}</td>
                            <td>{{ detail.keterangan }}</td>
                            <td>
                                <span class="badge rounded-pill " :class="[ detail.status == 'terpenuhi' ? 'text-bg-success' : 'text-bg-warning' ]" >
                                    {{ detail.status }}
                                </span>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else>
                Data belum tersedia!
            </div>
            <hr class="my-3 mx-n1">

            <div class="col-12 d-flex justify-content-center">
                <button type="button" class="btn btn-outline-danger mx-2" @click="closeModal">Tutup</button>
            </div>
        </div>
    </div>
</template>