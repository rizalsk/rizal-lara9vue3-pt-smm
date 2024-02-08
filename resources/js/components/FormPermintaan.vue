<script setup>
    //import ref
    import { ref, reactive, computed, onMounted, watch } from "vue";
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    import api from "@/api";
    import { errorHandler} from "@/api";
    import {formatDateString} from "@/vendor/moment";
    import VueDatePicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css';
    import useVuelidate from '@vuelidate/core';
    import { helpers, required, minValue } from '@vuelidate/validators';
    import {notify} from "@/vendor/toaster";


    // emit
    const emit = defineEmits(['toggle-loading', 'close-modal'])

    //define state
    const errors = ref([]);

    const detailBarang = {
        barang_id: null, 
        lokasi: null, 
        stock: null, 
        kuantiti: null, 
        satuan: null, 
        status: null, 
    };

    let formData = reactive({
        'staff_nik': null,
        'nama': null,
        'departemen': null,
        'tanggal_permintaan': null,
        'barangs':[
           detailBarang 
        ]
    });

    const resetForm = () => {
        formData = {
            ...formData,
            ...{
                'staff_nik': null,
                'nama': null,
                'departemen': null,
                'tanggal_permintaan': new Date()
            }
        };
        employee.value = null;
        formData.barangs = [];
        details.value = [];
        barangModel.value = [];
        lokasiModel.value = [];
        stockModel.value = [];
        kuantitiModel.value = [];
        satuanModel.value = [];
        keteranganModel.value = [];
        statusModel.value = [];
    }
    
    const rules = {
        'staff_nik': {
            required
        },
        'nama': {
            required
        },
        'departemen': {
            required
        },
        'tanggal_permintaan': {
            required
        },
        'barangs': {
            required,
            $each: helpers.forEach({
                barang_id: {
                    required
                },
                lokasi: {
                    required,
                },
                stock: {
                    required,
                    minValue: minValue(1)
                },
                kuantiti: {
                    required,
                    minValue: minValue(1)
                },
                satuan: {
                    required
                },
                status: {
                    required
                },
            })
        }
    };

    const v$ = useVuelidate(rules, formData);

    const staff = ref([]);
    const barangs = ref([]);
    const employee = ref(null);
    
    const detailForm = {
        ...detailBarang,
        ...{
            barang:null,
            keterangan: null
        }
    }

    const details = ref([]);
    const barangModel = ref([])
    const lokasiModel = ref([])
    const stockModel = ref([])
    const kuantitiModel = ref([])
    const satuanModel = ref([])
    const keteranganModel = ref([])
    const statusModel = ref([])
    let barangoptions =  computed(() => {
        return barangs.value;
    })

    // methods
    const closeModal = () => {
        resetForm();
        emit('close-modal')
    }

    // FetchData
    const getStaff = async () => {
        //fetch data 
        await api.get('/staff')
        .then(response => {
            //set response data to state "staff"
            staff.value = response.data.data;
        })
        .catch(errorHandler)
        .finally(()=>{
            emit('toggle-loading', false);
        })
    }

    const getBarangs = async () => {
        //fetch data 
        await api.get('/barang')
        .then(response => {
            //set response data to state "perminstaans"
            barangs.value = response.data.data;
            barangoptions = barangs.value;
        })
        .catch(errorHandler)
        .finally(()=>{
            emit('toggle-loading', false);
        })
    }

    const reloadData = () => {
        getStaff();
        getBarangs();
    }

    // Form Methods
    const addDetail = () => {
        details.value.push(detailForm)
        barangModel.value.push(null)
        lokasiModel.value.push(null)
        stockModel.value.push(null)
        kuantitiModel.value.push(1)
        satuanModel.value.push(null)
        keteranganModel.value.push(null)
        statusModel.value.push('tidak terpenuhi')
    }

    const removeDetail = (idx) => {
        details.value.splice(idx, 1);
        barangModel.value.splice(idx, 1);
        lokasiModel.value.splice(idx, 1);
        stockModel.value.splice(idx, 1);
        kuantitiModel.value.splice(idx, 1);
        satuanModel.value.splice(idx, 1);
        keteranganModel.value.splice(idx, 1);
        statusModel.value.splice(idx, 1);
    }

    const logger = (selected, y = null) => {
        const selectedIds = [];
        barangModel.value.forEach((item, idx) => {
            lokasiModel.value[idx] = barangModel.value[idx] != null ? barangModel.value[idx].lokasi.nama : null;
            stockModel.value[idx] = barangModel.value[idx] != null ? barangModel.value[idx].stock : null;
            stockModel.value[idx] = barangModel.value[idx] != null ? barangModel.value[idx].stock : null;
            satuanModel.value[idx] = barangModel.value[idx] != null ? barangModel.value[idx].satuan : null;
            statusModel.value[idx] = checkQty( intVal(stockModel.value[idx]) , intVal(kuantitiModel.value[idx]) ) ? 'terpenuhi' : 'tidak terpenuhi';
            if(item !== null) {
                selectedIds.push(intVal(item.id))
            }
        });
        barangoptions = barangs.value.filter(i => !selectedIds.includes(i.id))
    }

    const qtyChanged = (event) => {
        const idx = intVal(event.currentTarget.dataset.index);
        const qty = intVal(event.target.value);
        const stock = intVal(stockModel.value[idx]);
        statusModel.value[idx] = checkQty(stock, qty) ? 'terpenuhi' : 'tidak terpenuhi';
    }

    const checkQty = ( stock, qty ) => {
        return stock >= qty;
    }

    // formatter
    const formatDate = (date) => {
        const stringDate = date.toString();
        return formatDateString(stringDate);
    }

    const intVal = (i) => {
        return typeof i === 'string'
            ? i.replace(/[\$,]/g, '') * 1
            : typeof i === 'number'
                ? i
                : 0;
    };

    // formatter
    const formatPreviewDate = (date) => {
        const stringDate = date.toString();
        return formatDateString(stringDate, "DD MMMM YYYY HH:mm");
    }

    //method "storePermintaan"
    const storePermintaan = async () => {
        const result = await v$.value.$validate();
        formData.tanggal_permintaan = formatDateString(formData.tanggal_permintaan);
        if(result){
            emit('toggle-loading', true);
            await api.post('/permintaans', formData)
            .then(response => {
                notify("success", response.data.message);
                reloadData();
                resetForm();
                emit('created');
                emit('close-modal');
            })
            .catch(errorHandler)
            .finally(()=>{
                emit('toggle-loading', false);
            })
        }else{
            //alert("invalid data");
            v$.value.$errors.forEach((error, idx) => {
                notify('error',  `${error.$property} ${error.$message}`)
            })
        }
    };
    
    // life cycle
    onMounted(() => {
        reloadData();
    })

    watch(employee, async (newStaff, oldStaff) => {
        if(newStaff !== null){
            formData.staff_nik = newStaff.nik;
            formData.nama = newStaff.nama;
            formData.departemen = newStaff.departemen.nama;
        }else{
            formData.staff_nik = null;
            formData.nama = null;
            formData.departemen = null;
        }
    },{ deep: true });

    watch([barangModel, kuantitiModel, keteranganModel, statusModel], async (newValue) => {
        let newDetails = [];
        barangModel.value.forEach((item, idx) => {
            if(item !== null) {
                newDetails.push(
                    {
                        ...detailBarang,
                        ...{
                            barang_id:item.id,
                            lokasi:item.lokasi.nama,
                            stock:item.stock,
                            kuantiti:kuantitiModel.value[idx],
                            satuan:satuanModel.value[idx],
                            keterangan:keteranganModel.value[idx],
                            status:statusModel.value[idx],
                        }
                    }
                );
            }
        });

        if(newDetails.length > 0){
            formData.barangs = newDetails;
        }else{
            const totalQty = kuantitiModel.value.length > 0 ? kuantitiModel.value[0] : 0;
            const currentStats = statusModel.value.length > 0 ? statusModel.value[0] : null;
            const curretKet = keteranganModel.value.length > 0 ? keteranganModel.value[0] : null;

            formData.barangs = [{
                ...detailBarang,
                ...{
                    kuantiti: totalQty,
                    status: currentStats,
                    keterangan: curretKet
                }
            }];
        }
    },{ deep: true });

</script>

<template>
    <h4 class="mb-3 text-center">Form Permintaan Barang</h4>
                
    <form @submit.prevent="storePermintaan" class="row g-3 needs-validation" novalidate id="form-permintaan">

        <div class="col-md-4">
            <label for="validationCustom01" class="form-label">NIK Peminta:</label>
            <vSelect id="staff" label="nik" :options="staff" v-model="employee">
                <template #search="{attributes, events}">
                    <input
                    class="vs__search"
                    :required="!selected"
                    v-bind="attributes"
                    v-on="events"
                    />
                </template>
            </vSelect>
            <input type="hidden" name="staff_nik" id="staff_nik" v-model="formData.staff_nik">

            <small class="text-danger" v-for="error of v$.staff_nik.$errors" :key="error.$uid">
                {{ error.$property }} - {{ error.$message }}
            </small>
            
        </div>
        <div class="col-md-4">
            <label for="staff-nama" class="form-label">Nama:</label>
            <input type="text" class="form-control" id="staff-nama" aria-label="readonly input" readonly required :value="formData.nama">
            <small class="text-danger" v-for="error of v$.nama.$errors" :key="error.$uid">
                {{ error.$property }} - {{ error.$message }}
            </small>
        </div>
        <div class="col-md-4">
            <label for="staff-departemen" class="form-label">Departemen:</label>
            <input type="text" class="form-control" id="staff-departemen" v-model="formData.departemen" required readonly>
            <small class="text-danger" v-for="error of v$.departemen.$errors" :key="error.$uid">
                {{ error.$property }} - {{ error.$message }}
            </small>
        </div>
        <div class="col-md-4">
            <label for="tanggal_permintaan" class="form-label">Tanggal Permintaan:</label>
            <VueDatePicker id="tanggal_permintaan" v-model="formData.tanggal_permintaan" :format="formatPreviewDate" :preview-format="formatDate" time-picker-inline></VueDatePicker>
            <small class="text-danger" v-for="error of v$.tanggal_permintaan.$errors" :key="error.$uid">
                {{ error.$property }} - {{ error.$message }}
            </small>
        </div>
        
        <hr class="mt-3">
        <div class="col-md-12 mt-0 table-responsive">
            <div class="mb-3">
                <strong>Daftar Barang</strong>
            </div>

            <small class="text-danger" v-if="barangoptions.length === barangs.length">
                barang tidak boleh kosong
            </small>
            
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th style="min-width:17rem;max-width: 17rem;;">Barang</th>
                        <th class="text-center">Lokasi</th>
                        <th class="text-center">Tersedia</th>
                        <th class="text-center">Kuantiti</th>
                        <th class="text-center">Satuan</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">*</th>
                    </tr>
                </thead>
                <tbody v-if="details.length > 0">
                    <tr v-for="(detail, index) in details" :key="`details-${index}`">
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <span class="align-self-center">{{ index + 1 }}</span>
                            </div>
                        </td>
                        <td style="min-width: 17rem; max-width: 17rem;">
                            <vSelect 
                                placeholder="Pilih barang"
                                v-model="barangModel[index]"
                                :options="barangoptions" 
                                label="code"
                                @update:modelValue="logger"
                                >
                                <template v-slot:option="option">
                                    {{ option.code }} - {{ option.nama }}
                                </template>
                                <template v-slot:selected-option="option">
                                    {{ option.code }} - {{ option.nama }}
                                </template>
                            </vSelect>
                            <div v-if="v$.barangs.$each.$response.$errors[index]">
                                <small class="text-danger"
                                    v-for="error in v$.barangs.$each.$response.$errors[index].barang_id"
                                    :key="error"
                                    >
                                    barang {{ error.$message }}
                                </small>
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control" aria-label="readonly input" v-model="lokasiModel[index]" readonly required>
                            <div v-if="v$.barangs.$each.$response.$errors[index]">
                                <small class="text-danger"
                                    v-for="error in v$.barangs.$each.$response.$errors[index].lokasi"
                                    :key="error"
                                    >
                                    barang {{ error.$message }}
                                </small>
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control" aria-label="readonly input" :value="stockModel[index]" readonly required>

                            <div v-if="v$.barangs.$each.$response.$errors[index]">
                                <small class="text-danger"
                                    v-for="error in v$.barangs.$each.$response.$errors[index].stock"
                                    :key="error"
                                    >
                                    barang {{ error.$message }}
                                </small>
                            </div>
                        </td>
                        <td>
                            <input type="number" class="form-control text-center" aria-label="readonly input" v-model="kuantitiModel[index]" min="1" @input="qtyChanged($event)" @change="qtyChanged($event)" :data-index="index" required>
                            <div v-if="v$.barangs.$each.$response.$errors[index]">
                                <small class="text-danger"
                                    v-for="error in v$.barangs.$each.$response.$errors[index].kuantiti"
                                    :key="error"
                                    >
                                    barang {{ error.$message }}
                                </small>
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control" aria-label="readonly input" v-model="satuanModel[index]" readonly required>
                            <div v-if="v$.barangs.$each.$response.$errors[index]">
                                <small class="text-danger"
                                    v-for="error in v$.barangs.$each.$response.$errors[index].satuan"
                                    :key="error"
                                    >
                                    barang {{ error.$message }}
                                </small>
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control" aria-label="readonly input" v-model="keteranganModel[index]">
                        </td>
                        <td>
                            <input type="hidden" class="form-control" aria-label="readonly input" v-model="statusModel[index]" readonly required>

                            <span class="badge rounded-pill" :class="[ statusModel[index] == 'terpenuhi' ? 'bg-success' : 'bg-danger' ]">{{ statusModel[index] }}</span>

                            <div v-if="v$.barangs.$each.$response.$errors[index]">
                                <small class="text-danger"
                                    v-for="error in v$.barangs.$each.$response.$errors[index].status"
                                    :key="error"
                                    >
                                    barang {{ error.$message }}
                                </small>
                            </div>
                            
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-dark rounded-circle" @click="removeDetail(index)">
                                <i class="bi bi-x fs-6"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        

        <hr class="my-3">
        <div class="col-md-12 d-flex justify-content-end">
            <button type="button" class="btn btn-success btn-sm" :class="[ barangoptions.length <= 0 || details.length >= barangs.length ? 'disabled' : '' ]"  @click="addDetail">
                <i class="bi bi-plus"></i> Tambah
            </button>
        </div>

        <hr class="my-3 mx-n1">

        <div class="col-12 d-flex justify-content-center">
            <button type="submit" class="btn btn-dark mx-2">Proses</button>
            <button type="button" class="btn btn-outline-danger mx-2" @click="closeModal">Batal</button>
        </div>
    </form>
</template>