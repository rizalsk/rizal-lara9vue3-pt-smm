<template>
    <div class="d-fex text-center mt-5">
        <h5>Data Permintaan Barang</h5>
    </div>
    
    <div class="card border-0 rounded shadow">
        <div class="card-body ">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <button type="button" class="btn btn-primary" @click="createPermintaan">
                        <i class="bi bi-plus-circle-dotted"></i> Buat Permintaan
                    </button>
                </div>
                <!-- <div>
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search...">
                </div> -->
                
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-hover table-bordered">
                    <thead class="thead-light text-white">
                        <tr>
                            <th class="text-center" scope="col">NIK Peminta</th>
                            <th class="text-center" scope="col">Nama</th>
                            <th class="text-center" scope="col">Departemen</th>
                            <th class="text-center" scope="col">Tanggal Permintaan</th>
                            <th class="text-center" scope="col" style="width:15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="permintaans.length == 0 && !loading">
                            <td colspan="5" class="text-center">
                                <div class="alert alert-danger mb-0">
                                    Data Belum Tersedia!
                                </div>
                            </td>
                        </tr>
                        <tr v-else v-for="(permintaan, index) in permintaans" :key="index">
                            
                            <td>{{ permintaan.staff_nik }}</td>
                            <td>{{ permintaan.staff.nama }}</td>
                            <td>{{ permintaan.staff.departemen.nama }}</td>
                            <td>{{ formatDate(permintaan.tanggal_permintaan)  }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info rounded-sm shadow border-0 mx-1 rounded-circle" @click="showDetail(permintaan.id)">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <!-- <button class="btn btn-sm btn-warning rounded-sm shadow border-0 mx-1 rounded-circle">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <button class="btn btn-sm btn-danger rounded-sm shadow border-0 mx-1 rounded-circle">
                                    <i class="bi bi-trash-fill"></i>
                                </button> -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade show" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <div class="modal-header bg-deep-purple-900 p-2 text-white">
                    <div>
                        <strong class="modal-title" id="staticBackdropLabel">Modal title</strong>
                    </div>
                    <button type="button" class="btn-close" @click="myModal.hide()" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <TabelPermintaan v-if="aksi == 'show'" :permintaan="permintaan" @close-modal="myModal.hide()"/>
                    <FormPermintaan @created="fetchDataPermintaans" v-if="aksi == 'create'" @close-modal="myModal.hide()"/>
                </div>


            </div>
        </div>
    </div>
</template>


<script>
import api from "@/api";
import {notify} from "@/vendor/toaster";
import {formatDateString} from "@/vendor/moment";

import TabelPermintaan from '@/components/TabelPermintaan.vue';
import FormPermintaan from '@/components/FormPermintaan.vue';

export default {
    name: "Permintaan",
    setup(){
        return {}
    },
    props: {
        loading: {
            Boolean,
            default: false
        }
    },
    components:{
        TabelPermintaan,
        FormPermintaan,
    },
    data(){
        return{
            errorMessage:'',
            permintaans:[],
            permintaan:{},
            myModal: null,
            aksi: 'list',
            errors:{}
        }
    },
    methods:{
        errorHandler(error){
            let selferrors = error
            if(error.response != undefined){
                if (error.response.data.message != undefined) {
                    selferrors = error.response.data.message
                }
            }
            notify('error', selferrors)
        },
        async fetchDataPermintaans(){
            //fetch data 
            await api.get('/permintaans')
            .then(response => {
                //set response data to state "perminstaans"
                this.permintaans = response.data.data;
            })
            .catch(this.errorHandler)
            .finally(()=>{
                this.$emit('toggle-loading', false);
            })
        },
        async showDetail(id){
            //fetch data 
            this.$emit('toggle-loading', true);
            await api.get(`/permintaans/${id}`)
            .then(response => {
                //set response data to state "perminstaans"
                this.permintaan = response.data.data;
                this.aksi = 'show';
                this.myModal.show()
            })
            .catch(this.errorHandler)
            .finally(()=>{
                this.$emit('toggle-loading', false);
            })
        },
        createPermintaan(){
            this.aksi = 'create'
            this.myModal.show();
        },
        formatDate(value ) {
            return formatDateString(value, "DD MMMM YYYY HH:mm"); 
        },
    },
    mounted() {
        this.myModal = new bootstrap.Modal(document.getElementById('myModal'))
        this.$emit('toggle-loading', true);
        this.fetchDataPermintaans()
    },
}
</script>

<style>

</style>