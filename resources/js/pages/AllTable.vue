<template>
    <div class="d-flex flex-column bd-highlight mb-3 justify-content-center ">
        
        <div>
            <div class="card" >
                <div class="card-body">

                    <div class="d-fex text-center mt-5">
                        <h5>Data Staff</h5>
                    </div>
                    <table class="table table-bordered ">
                        <thead class="table-dark">
                            <tr>
                            <th scope="col" width="60" class="text-center">#</th>
                            <th scope="col" class="text-center">NIK</th>
                            <th scope="col" class="text-center">Nama</th>
                            <th scope="col" class="text-center">Departemen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="staff.length == 0 && !loading">
                                <td colspan="5" class="text-center">
                                    <div class="alert alert-danger mb-0">
                                        Data Belum Tersedia!
                                    </div>
                                </td>
                            </tr>
                            <tr v-else  v-for="(empl, index) in staff" :key="`staff-${index}`">
                                <td>{{ index + 1 }}</td>
                                <td>{{ empl.nik }}</td>
                                <td>{{ empl.nama }}</td>
                                <td>{{ empl.departemen.nama }}</td>
                                
                            </tr>
                        </tbody>
                    </table>

                    <div class="d-fex text-center mt-5">
                        <h5>Data Barang</h5>
                    </div>
                    <table class="table table-bordered ">
                        <thead class="table-dark">
                            <tr>
                            <th scope="col" width="60" class="text-center">#</th>
                            <th scope="col" class="text-center">Barang</th>
                            <th scope="col" class="text-center">Lokasi</th>
                            <th scope="col" class="text-center">Tersedia</th>
                            <th scope="col" class="text-center">Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="barangs.length == 0 && !loading">
                                <td colspan="5" class="text-center">
                                    <div class="alert alert-danger mb-0">
                                        Data Belum Tersedia!
                                    </div>
                                </td>
                            </tr>
                            <tr v-else  v-for="(barang, index) in barangs" :key="`barang-${index}`">
                                <td>{{ index + 1 }}</td>
                                <td>{{ barang.code }} - {{ barang.nama }}</td>
                                <td>{{ barang.lokasi.nama }}</td>
                                <td class="text-center">{{ barang.stock }}</td>
                                <td>{{ barang.satuan }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="d-fex text-center mt-5">
                        <h5>Data Detail Permintaan</h5>
                    </div>
                    <table class="table table-bordered ">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" width="60" class="text-center">#</th>
                                <th scope="col" class="text-center">NIK Peminta</th>
                                <th scope="col" class="text-center">Nama</th>
                                <th scope="col" class="text-center">Tgl. Permintaan</th>
                                <th scope="col" class="text-center">Barang</th>
                                <th scope="col" class="text-center">Lokasi</th>
                                <th scope="col" class="text-center">Tersedia</th>
                                <th scope="col" class="text-center">Kuantiti</th>
                                <th scope="col" class="text-center">Satuan</th>
                                <th scope="col" class="text-center">Keterangan</th>
                                <th scope="col" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="details.length == 0 && !loading">
                                <td colspan="11" class="text-center">
                                    <div class="alert alert-danger mb-0">
                                        Data Belum Tersedia!
                                    </div>
                                </td>
                            </tr>
                            <tr v-else  v-for="(detail, index) in details" :key="`detail-${index}`">
                                <td>{{ index + 1 }}</td>
                                <td>{{ detail.permintaan.staff_nik }}</td>
                                <td>{{ detail.permintaan.staff.nama }}</td>
                                <td>{{ detail.permintaan.tanggal_permintaan }}</td>
                                <td>{{ detail.barang.code }} - {{ detail.barang.nama }}</td>
                                <td>{{ detail.barang.lokasi.nama }}</td>
                                <td class="text-center">{{ detail.barang.stock }}</td>
                                <td class="text-center">{{ detail.kuantiti }}</td>
                                <td class="text-center">{{ detail.barang.satuan }}</td>
                                <td class="text-center">{{ detail.keterangan }}</td>
                                <td >
                                    <span class="badge rounded-pill" :class="[ detail.status == 'terpenuhi' ? 'bg-success' : 'bg-danger' ]">{{ detail.status }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="d-fex text-center mt-5">
                        <h5>Data Departemen</h5>
                    </div>
                    <table class="table table-bordered ">
                        <thead class="table-dark">
                            <tr>
                            <th scope="col" width="60" class="text-center">#</th>
                            <th scope="col" class="text-center">Nama Departemen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="departemens.length == 0 && !loading">
                                <td colspan="5" class="text-center">
                                    <div class="alert alert-danger mb-0">
                                        Data Belum Tersedia!
                                    </div>
                                </td>
                            </tr>
                            <tr v-else  v-for="(dept, index) in departemens" :key="`dept-${index}`">
                                <td>{{ index + 1 }}</td>
                                <td>{{ dept.nama }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="d-fex text-center mt-5">
                        <h5>Data Lokasi</h5>
                    </div>
                    <table class="table table-bordered ">
                        <thead class="table-dark">
                            <tr>
                            <th scope="col" width="60" class="text-center">#</th>
                            <th scope="col" class="text-center">Nama Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="lokasis.length == 0 && !loading">
                                <td colspan="5" class="text-center">
                                    <div class="alert alert-danger mb-0">
                                        Data Belum Tersedia!
                                    </div>
                                </td>
                            </tr>
                            <tr v-else  v-for="(lokasi, index) in lokasis" :key="`lokasi-${index}`">
                                <td>{{ index + 1 }}</td>
                                <td>{{ lokasi.nama }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {onMounted, ref, toRefs} from 'vue';
import api from '@/api';
import {errorHandler} from '@/api';
import {notify} from "@/vendor/toaster";


export default {
    props:{
        loading:{
            type: Boolean,
            default: true,
        }
    },
    setup(props, {attrs, slots, emit}){
        const {loading} = toRefs(props)
        const staff = ref([])
        const details = ref([])
        const barangs = ref([])
        const departemens = ref([])
        const lokasis = ref([])

        const fetchStaff = async () => {
            emit('toggle-loading', true);
            await api.get(`/staff`)
            .then(response => {
                staff.value = response.data.data;
                fetchBarangs()
                fetchDetails()
                fetchDepartemen()
                fetchLokasi()
            })
            .catch(errorHandler)
            .finally(()=>{
                emit('toggle-loading', false)
            })
        };

        const fetchDepartemen = async () => {
            emit('toggle-loading', true);
            await api.get(`/departemen`)
            .then(response => {
                departemens.value = response.data.data;
            })
            .catch(errorHandler)
            .finally(()=>{
                emit('toggle-loading', false)
            })
        };

        const fetchBarangs = async () => {
            emit('toggle-loading', true);
            await api.get(`/barang`)
            .then(response => {
                barangs.value = response.data.data;
            })
            .catch(errorHandler)
            .finally(()=>{
                emit('toggle-loading', false)
            })
        };

        const fetchLokasi = async () => {
            emit('toggle-loading', true);
            await api.get(`/lokasi`)
            .then(response => {
                lokasis.value = response.data.data;
            })
            .catch(errorHandler)
            .finally(()=>{
                emit('toggle-loading', false)
            })
        };

        const fetchDetails = async () => {
            emit('toggle-loading', true);
            await api.get(`/details`)
            .then(response => {
                details.value = response.data.data;
            })
            .catch(errorHandler)
            .finally(()=>{
                emit('toggle-loading', false)
            })
        };

        onMounted(()=>{
            fetchStaff()
        })
        return {
            loading, staff, barangs, departemens, details, lokasis
        }
    }
}
</script>