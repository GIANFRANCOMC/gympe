<template>
    <Breadcrumb :list="breadcrumbTitles"/>

    <!-- Content -->
    <div class="row align-items-end g-3 mb-4">
        <InputSlot
            hasDiv
            title="Filtrar por"
            :titleClass="[config.forms.classes.title]"
            xl="3"
            lg="4">
            <template v-slot:input>
                <v-select
                    v-model="lists.entity.filters.filter_by"
                    :options="filterByOptions"
                    :class="config.forms.classes.select2"
                    :clearable="false"/>
            </template>
        </InputSlot>
        <InputText
            v-model="lists.entity.filters.word"
            @enterKeyPressed="listEntity({})"
            hasDiv
            title="Búsqueda"
            :titleClass="[config.forms.classes.title]"
            xl="4"
            lg="4"/>
        <InputSlot
            hasDiv
            :isInputGroup="false"
            xl="5"
            lg="4">
            <template v-slot:input>
                <button type="button" class="btn btn-primary waves-effect" @click="listEntity({})">
                    <i class="fa fa-search"></i>
                    <span class="ms-2">Buscar</span>
                </button>
            </template>
        </InputSlot>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr class="text-center align-middle">
                    <th class="fw-bold col-1">CLIENTE</th>
                    <!-- <th class="fw-bold col-1">DURACIÓN</th> -->
                    <th class="fw-bold col-1">FECHA DE INICIO</th>
                    <th class="fw-bold col-1">FECHA DE FINALIZACIÓN</th>
                    <th class="fw-bold col-1">ORIGEN</th>
                    <th class="fw-bold col-1">ESTADO</th>
                    <th class="fw-bold col-1">ACCIONES</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0 bg-white">
                <template v-if="lists.entity.extras.loading">
                    <tr class="text-center">
                        <td colspan="99">
                            <Loader/>
                        </td>
                    </tr>
                </template>
                <template v-else>
                    <template v-if="lists.entity.records.total > 0">
                        <tr v-for="record in lists.entity.records.data" :key="record.id" class="text-center">
                            <td class="text-start">
                                <span v-text="record.customer?.name" class="fw-bold d-block"></span>
                                <small v-text="record.customer?.document_number" class="d-block"></small>
                            </td>
                            <!-- <td>
                                <span v-text="record.formatted_duration" class="badge bg-label-primary fw-bold"></span>
                            </td> -->
                            <td>
                                <span v-text="legibleFormatDate({dateString: record.start_date, type: 'date'})" class="d-block fw-semibold"></span>
                                <span v-text="legibleFormatDate({dateString: record.start_date, type: 'time'})" class="d-block fw-semibold"></span>
                            </td>
                            <td>
                                <span v-text="legibleFormatDate({dateString: record.end_date, type: 'date'})" class="d-block fw-semibold"></span>
                                <span v-text="legibleFormatDate({dateString: record.end_date, type: 'time'})" class="d-block fw-semibold"></span>
                            </td>
                            <td class="text-center">
                                <span v-text="record.formatted_type" class="d-block fw-bold"></span>
                            </td>
                            <td>
                                <span :class="['badge', 'text-capitalize', { 'bg-label-success': ['active'].includes(record.status), 'bg-label-danger': ['inactive', 'canceled'].includes(record.status) }]" v-text="record.formatted_status"></span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary waves-effect" @click="modalActionsEntity({record})">
                                    <i class="fa fa-gear"></i>
                                    <span class="ms-2">Acciones</span>
                                </button>
                            </td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr>
                            <td class="text-center" colspan="99">
                                <WithoutData type="image"/>
                            </td>
                        </tr>
                    </template>
                </template>
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center" v-if="!lists.entity.extras.loading && lists.entity.records?.total > 0">
        <Paginator :links="lists.entity.records.links" @clickPage="listEntity"/>
    </div>

    <div class="modal fade" :id="forms.entity.createUpdate.extras.modals.actions.id" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase fw-bold"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center g-1">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <span class="fw-semibold">• Cliente:</span>
                            <span class="ms-2" v-text="forms.entity.createUpdate.extras.modals.actions.data?.customer?.name"></span>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <span class="fw-semibold">• Fecha de inicio:</span>
                            <span class="ms-2" v-text="legibleFormatDate({dateString: forms.entity.createUpdate.extras.modals.actions.data?.start_date, type: 'datetime'})"></span>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <span class="fw-semibold">• Fecha de finalización:</span>
                            <span class="ms-2" v-text="legibleFormatDate({dateString: forms.entity.createUpdate.extras.modals.actions.data?.end_date, type: 'datetime'})"></span>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <span class="fw-semibold">• Origen:</span>
                            <span class="ms-2" v-text="forms.entity.createUpdate.extras.modals.actions.data?.formatted_type"></span>
                            <span v-if="isDefined({value: forms.entity.createUpdate.extras.modals.actions.data?.sale_header?.serie_sequential})" class="ms-2 fw-semibold" v-text="forms.entity.createUpdate.extras.modals.actions.data?.sale_header?.serie_sequential"></span>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <span class="fw-semibold">• Estado:</span>
                            <span class="ms-2" v-text="forms.entity.createUpdate.extras.modals.actions.data?.formatted_status"></span>
                        </div>
                        <div v-if="['canceled'].includes(forms.entity.createUpdate.extras.modals.actions.data?.status)" class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <span class="fw-semibold">• Motivo:</span>
                            <span class="ms-2" v-text="forms.entity.createUpdate.extras.modals.actions.data?.motive"></span>
                        </div>
                        <div v-if="['active'].includes(forms.entity.createUpdate.extras.modals.actions.data?.status)" class="col-xl-3 col-lg-3 col-md-3 col-sm-3 mt-4">
                            <div class="text-center cursor-pointer p-1" @click="cancelEntity({})">
                                <div class="badge bg-danger p-3 rounded mb-1">
                                    <i class="fa-solid fa-rectangle-xmark fs-3"></i>
                                </div>
                                <span class="d-block fw-semibold">Anular suscripción</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import * as Alerts    from "../../Helpers/Alerts.js";
import * as Constants from "../../Helpers/Constants.js";
import * as Requests  from "../../Helpers/Requests.js";
import * as Utils     from "../../Helpers/Utils.js";

export default {
    components: {
        //
    },
    mounted: async function() {

        Utils.navbarItem("menu-item-trackings", {addClass: "open"});
        Utils.navbarItem(this.config.entity.page.menu.id, {});
        Alerts.swals({type: "initParams"});

        let initParams = await this.initParams({}),
            initOthers = await this.initOthers({});

        if(initParams && initOthers) {

            Alerts.swals({show: false});
            this.listEntity({});

        }

    },
    data() {
        return {
            lists: {
                entity: {
                    extras: {
                        loading: false,
                        route: Requests.config({entity: "trackingSubscriptions", type: "list"})
                    },
                    filters: {
                        filter_by: null,
                        word: ""
                    },
                    records: {
                        total: 0
                    }
                }
            },
            forms: {
                entity: {
                    createUpdate: {
                        extras: {
                            modals: {
                                actions: {
                                    id: Utils.uuid(),
                                    data: {
                                        id: null
                                    }
                                }
                            }
                        },
                        data: {
                            id: null,
                            status: null
                        },
                        errors: {}
                    }
                }
            },
            options: {},
            config: {
                ...Constants.generalConfig,
                entity: {
                    ...Requests.config({entity: "trackingSubscriptions"}),
                    page: {
                        title: "Suscripciones",
                        active: true,
                        menu: {
                            id: "menu-item-trackings-subscriptions"
                        }
                    }
                }
            }
        };
    },
    methods: {
        // Init
        async initParams({}) {

            let initParams = await Requests.get({route: this.config.entity.routes.initParams, data: {page: "main"}, showAlert: true});

            this.options.subscriptions = initParams.data?.config?.subscriptions;

            return Requests.valid({result: initParams});

        },
        async initOthers({}) {

            return new Promise(resolve => {

                this.lists.entity.filters.filter_by = this.filterByOptions[0];

                resolve(true);

            });

        },
        // Entity forms
        async listEntity({url = null}) {

            let filters = Utils.cloneJson(this.lists.entity.filters);
            const filterJson = {filter_by: filters?.filter_by?.code, word: filters.word};

            this.lists.entity.extras.loading = true;
            this.lists.entity.records        = (await Requests.get({route: url || this.lists.entity.extras.route, data: filterJson}))?.data;
            this.lists.entity.extras.loading = false;

        },
        // Forms
        modalActionsEntity({record = null}) {

            this.forms.entity.createUpdate.extras.modals.actions.data = record;

            Alerts.modals({type: "show", id: this.forms.entity.createUpdate.extras.modals.actions.id});

        },
        cancelEntity({}) {

            const functionName = "cancelEntity";

            this.formErrors({functionName, type: "clear"});

            let form = Utils.cloneJson(this.forms.entity.createUpdate.extras.modals.actions.data);

            const validateForm = this.validateForm({functionName, form});

            Alerts.modals({type: "hide", id: this.forms.entity.createUpdate.extras.modals.actions.id});

            if(validateForm?.bool) {

                let el = this;

                Swal.fire({
                    html: `<span class="d-block my-1">¿Desea anular la venta suscripción del cliente <b>${form.customer?.name}</b>?</span>
                           <div class="form-group text-start mt-2">
                                <label class="form-label colon-at-end">Motivo</label>
                                <label class="text-danger ms-1 fw-bold">*</label>
                                <div class="input-group">
                                    <textarea type="text" class="form-control no-resize" maxlength="999" id="motiveId"></textarea>
                                </div>
                           </div>`,
                    icon: "warning",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    confirmButtonText: "Sí, anular",
                    cancelButtonText: "Cancelar",
                    customClass: {
                        confirmButton: "btn btn-primary waves-effect",
                        cancelButton: "btn btn-secondary waves-effect ms-3"
                    }
                }).then(async function(result) {

                    if(result.isConfirmed) {

                        const motive = Swal.getHtmlContainer().querySelector("#motiveId").value;

                        Alerts.swals({});

                        let cancel = await Requests.patch({route: el.config.entity.routes.cancel, data: {motive}, id: form.id});

                        if(Requests.valid({result: cancel})) {

                            Alerts.toastrs({type: "success", subtitle: cancel?.data?.msg});
                            Alerts.swals({show: false});

                            el.listEntity({})

                        }else {

                            Alerts.toastrs({type: "error", subtitle: cancel?.data?.msg});
                            Alerts.swals({show: false});

                        }

                    }else if(result.isDismissed) {

                        //

                    }

                })

            }else {

                Alerts.generateAlert({messages: Utils.getErrors({errors: validateForm}), msgContent: `<div class="fw-semibold mb-2">${this.config.messages.errorValidate}</div>`});

            }

            Alerts.tooltips({show: false});

        },
        // Forms utils
        clearForm({functionName}) {

            switch(functionName) {
                case "modalCreateUpdateEntity":
                case "createUpdateEntity":
                    //
                    break;
            }

        },
        formErrors({functionName, type = "clear", errors = []}) {

            if(["modalCreateUpdateEntity", "createUpdateEntity"].includes(functionName)) {

                this.forms.entity.createUpdate.errors = ["set"].includes(type) ? errors : [];

            }

        },
        validateForm({functionName, form = null, extras = null}) {

            let result = {
                bool: true
            };

            if(["createUpdateEntity"].includes(functionName)) {

                result.internal_code = [];
                result.name          = [];
                result.description   = [];
                result.price         = [];
                result.currency      = [];
                result.status        = [];

                if(!this.isDefined({value: form?.internal_code})) {

                    result.internal_code.push(this.config.forms.errors.labels.required);
                    result.bool = false;

                }

                if(!this.isDefined({value: form?.name})) {

                    result.name.push(this.config.forms.errors.labels.required);
                    result.bool = false;

                }

                if(!this.isDefined({value: form?.price})) {

                    result.price.push(this.config.forms.errors.labels.required);
                    result.bool = false;

                }

                if(!this.isDefined({value: form?.currency})) {

                    result.currency.push(this.config.forms.errors.labels.required);
                    result.bool = false;

                }

                if(!this.isDefined({value: form?.status})) {

                    result.status.push(this.config.forms.errors.labels.required);
                    result.bool = false;

                }

            }

            return result;

        },
        // Others
        isDefined({value}) {

            return Utils.isDefined({value});

        },
        legibleFormatDate({dateString = null, type = "datetime"}) {

            return Utils.legibleFormatDate({dateString, type});

        }
    },
    computed: {
        breadcrumbTitles: function() {

            return [{title: "Seguimiento"}, this.config.entity.page];

        },
        filterByOptions: function() {

            return [
                // {code: "all", label: "Todos"},
                // {code: "name", label: "Tipo"}
                {code: "customer", label: "Cliente"}
            ];

        },
        statuses: function() {

            return this.options?.subscriptions?.statuses.map(e => ({code: e.code, label: e.label}));

        }
    },
    watch: {
        "lists.entity.filters.filter_by": function(newValue, oldValue) {

            // this.listEntity({});

        }
    }
};
</script>
