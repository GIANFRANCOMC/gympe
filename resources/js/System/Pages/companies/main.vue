<template>
    <Breadcrumb :list="breadcrumbTitles"/>

    <!-- Content -->
    <div class="card h-100">
        <div class="card-body">
            <div class="row g-3">
                <InputSlot
                    hasDiv
                    title="Tipo de documento"
                    isRequired
                    hasTextBottom
                    :textBottomInfo="forms.entity.createUpdate.errors?.identity_document_type"
                    xl="6"
                    lg="6">
                    <template v-slot:input>
                        <v-select
                            v-model="forms.entity.createUpdate.data.identity_document_type"
                            :options="identityDocumentTypes"
                            :clearable="false"/>
                    </template>
                </InputSlot>
                <InputText
                    v-model="forms.entity.createUpdate.data.document_number"
                    hasDiv
                    title="Número de documento"
                    isRequired
                    hasTextBottom
                    :textBottomInfo="forms.entity.createUpdate.errors?.document_number"
                    xl="6"
                    lg="6"/>
                <InputText
                    v-model="forms.entity.createUpdate.data.legal_name"
                    hasDiv
                    title="Nombre legal"
                    isRequired
                    hasTextBottom
                    :textBottomInfo="forms.entity.createUpdate.errors?.legal_name"
                    xl="6"
                    lg="6"/>
                <InputText
                    v-model="forms.entity.createUpdate.data.commercial_name"
                    hasDiv
                    title="Nombre comercial"
                    isRequired
                    hasTextBottom
                    :textBottomInfo="forms.entity.createUpdate.errors?.commercial_name"
                    xl="6"
                    lg="6"/>
                <InputText
                    v-model="forms.entity.createUpdate.data.address"
                    hasDiv
                    title="Dirección"
                    isRequired
                    hasTextBottom
                    :textBottomInfo="forms.entity.createUpdate.errors?.address"
                    xl="6"
                    lg="6"/>
                <InputText
                    v-model="forms.entity.createUpdate.data.telephone"
                    hasDiv
                    title="Teléfono"
                    isRequired
                    hasTextBottom
                    :textBottomInfo="forms.entity.createUpdate.errors?.telephone"
                    xl="6"
                    lg="6"/>
                <InputText
                    v-model="forms.entity.createUpdate.data.email"
                    hasDiv
                    title="Correo electrónico"
                    hasTextBottom
                    :textBottomInfo="forms.entity.createUpdate.errors?.email"
                    xl="6"
                    lg="6">
                    <template v-slot:inputGroupPrepend>
                        <a href="javascript:void(0)" class="btn btn-icon btn-label-dark waves-effect">
                            <i class="fa fa-envelope fs-5"></i>
                        </a>
                    </template>
                </InputText>
                <InputText
                    v-model="forms.entity.createUpdate.data.token_api_misc"
                    hasDiv
                    title="Token API - Misc"
                    hasTextBottom
                    :textBottomInfo="forms.entity.createUpdate.errors?.token_api_misc"
                    xl="6"
                    lg="6"/>
                <InputText
                    v-model="forms.entity.createUpdate.data.facebook"
                    hasDiv
                    title="Facebook"
                    hasTextBottom
                    :textBottomInfo="forms.entity.createUpdate.errors?.facebook"
                    xl="6"
                    lg="6">
                    <template v-slot:inputGroupPrepend>
                        <a href="javascript:void(0)" class="btn btn-icon btn-label-info waves-effect">
                            <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>
                        </a>
                    </template>
                </InputText>
                <InputText
                    v-model="forms.entity.createUpdate.data.instagram"
                    hasDiv
                    title="Instagram"
                    hasTextBottom
                    :textBottomInfo="forms.entity.createUpdate.errors?.instagram"
                    xl="6"
                    lg="6">
                    <template v-slot:inputGroupPrepend>
                        <a href="javascript:void(0)" class="btn btn-icon btn-label-danger waves-effect">
                            <i class="tf-icons fa-brands fa-instagram fs-5"></i>
                        </a>
                    </template>
                </InputText>
                <InputText
                    v-model="forms.entity.createUpdate.data.whatsapp"
                    hasDiv
                    title="Whatsapp"
                    hasTextBottom
                    :textBottomInfo="forms.entity.createUpdate.errors?.whatsapp"
                    xl="6"
                    lg="6">
                    <template v-slot:inputGroupPrepend>
                        <a href="javascript:void(0)" class="btn btn-icon btn-label-success waves-effect">
                            <i class="tf-icons fa-brands fa-whatsapp fs-5"></i>
                        </a>
                    </template>
                </InputText>
                <InputSlot
                    v-if="false"
                    hasDiv
                    title="Estado"
                    isRequired
                    hasTextBottom
                    :textBottomInfo="forms.entity.createUpdate.errors?.status"
                    xl="6"
                    lg="6">
                    <template v-slot:input>
                        <v-select
                            v-model="forms.entity.createUpdate.data.status"
                            :options="statuses"
                            :clearable="false"
                            :disabled="true"/>
                    </template>
                </InputSlot>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex flex-row-reverse">
                <button type="button" class="btn waves-effect btn-primary" @click="createUpdateEntity()">
                    <i class="fa fa-save"></i>
                    <span class="ms-2">Guardar</span>
                </button>
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

        Utils.navbarItem("menu-item-configuration", {addClass: "open"});
        Utils.navbarItem(this.config.entity.page.menu.id, {});
        Alerts.swals({type: "initParams"});

        let initParams = await this.initParams({}),
            initOthers = await this.initOthers({});

        if(initParams && initOthers) {

            Alerts.swals({show: false});

        }

    },
    data() {
        return {
            forms: {
                entity: {
                    createUpdate: {
                        extras: {
                            modals: {
                                default: {
                                    id: Utils.uuid(),
                                    titles: {
                                        store: "Agregar",
                                        update: "Editar"
                                    }
                                }
                            }
                        },
                        data: {
                            id: null,
                            identity_document_type: null,
                            document_number: "",
                            legal_name: "",
                            commercial_name: "",
                            address: "",
                            telephone: "",
                            email: "",
                            token_api_misc: "",
                            facebook: "",
                            instagram: "",
                            whatsapp: "",
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
                    ...Requests.config({entity: "companies"}),
                    page: {
                        title: "Mi empresa",
                        active: true,
                        menu: {
                            id: "menu-item-configuration-companies"
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

            this.options.companies             = initParams.data?.config?.companies;
            this.options.company               = initParams.data?.config?.company;
            this.options.identityDocumentTypes = initParams.data?.config?.identityDocumentTypes;

            return Requests.valid({result: initParams});

        },
        async initOthers({}) {

            return new Promise(resolve => {

                const company = (this.options.company?.records ?? []).length > 0 ? this.options.company?.records[0] : null;

                let identityDocumentType = this.identityDocumentTypes.filter(e => e.code === company?.identity_document_type_id)[0],
                    status               = this.statuses.filter(e => e.code === company?.status)[0];

                this.forms.entity.createUpdate.data.id                     = company?.id;
                this.forms.entity.createUpdate.data.identity_document_type = identityDocumentType;
                this.forms.entity.createUpdate.data.document_number        = company?.document_number;
                this.forms.entity.createUpdate.data.legal_name             = company?.legal_name;
                this.forms.entity.createUpdate.data.commercial_name        = company?.commercial_name;
                this.forms.entity.createUpdate.data.address                = company?.address;
                this.forms.entity.createUpdate.data.telephone              = company?.telephone;
                this.forms.entity.createUpdate.data.email                  = company?.email;
                this.forms.entity.createUpdate.data.token_api_misc         = company?.token_api_misc;
                this.forms.entity.createUpdate.data.facebook               = company?.facebook;
                this.forms.entity.createUpdate.data.instagram              = company?.instagram;
                this.forms.entity.createUpdate.data.whatsapp               = company?.whatsapp;
                this.forms.entity.createUpdate.data.status                 = status;

                resolve(true);

            });

        },
        // Forms
        async createUpdateEntity() {

            const functionName = "createUpdateEntity";

            Alerts.swals({});
            this.formErrors({functionName, type: "clear"});

            let form = Utils.cloneJson(this.forms.entity.createUpdate.data);

            const validateForm = this.validateForm({functionName, form});

            if(validateForm?.bool) {

                form.identity_document_type_id = form?.identity_document_type?.code;
                form.status = form?.status?.code;

                delete form.identity_document_type;

                let createUpdate = await (this.isDefined({value: form.id}) ? Requests.patch({route: this.config.entity.routes.update, data: form, id: form.id}) :
                                                                             Requests.post({route: this.config.entity.routes.store, data: form}));

                if(Requests.valid({result: createUpdate})) {

                    Alerts.modals({type: "hide", id: this.forms.entity.createUpdate.extras.modals.default.id});
                    Alerts.toastrs({type: "success", subtitle: createUpdate?.data?.msg});
                    Alerts.swals({show: false});

                    this.clearForm({functionName});

                }else {

                    this.formErrors({functionName, type: "set", errors: createUpdate?.errors ?? []});
                    Alerts.toastrs({type: "error", subtitle: createUpdate?.data?.msg});
                    Alerts.swals({show: false});

                }

            }else {

                this.formErrors({functionName, type: "set", errors: validateForm});
                Alerts.toastrs({type: "error", subtitle: this.config.messages.errorValidate});
                Alerts.swals({show: false});

            }

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

                result.identity_document_type = [];
                result.document_number        = [];
                result.legal_name             = [];
                result.commercial_name        = [];
                result.address                = [];
                result.telephone              = [];
                result.email                  = [];
                result.token_api_misc         = [];
                result.status                 = [];

                if(!this.isDefined({value: form?.identity_document_type})) {

                    result.identity_document_type.push(this.config.forms.errors.labels.required);
                    result.bool = false;

                }

                if(!this.isDefined({value: form?.document_number})) {

                    result.document_number.push(this.config.forms.errors.labels.required);
                    result.bool = false;

                }

                if(!this.isDefined({value: form?.legal_name})) {

                    result.legal_name.push(this.config.forms.errors.labels.required);
                    result.bool = false;

                }

                if(!this.isDefined({value: form?.commercial_name})) {

                    result.commercial_name.push(this.config.forms.errors.labels.required);
                    result.bool = false;

                }

                if(!this.isDefined({value: form?.address})) {

                    result.address.push(this.config.forms.errors.labels.required);
                    result.bool = false;

                }

                if(!this.isDefined({value: form?.telephone})) {

                    result.telephone.push(this.config.forms.errors.labels.required);
                    result.bool = false;

                }

                /* if(!this.isDefined({value: form?.email})) {

                    result.email.push(this.config.forms.errors.labels.required);
                    result.bool = false;

                } */

                /* if(!this.isDefined({value: form?.token_api_misc})) {

                    result.token_api_misc.push(this.config.forms.errors.labels.required);
                    result.bool = false;

                } */

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
        fixedNumber(value) {

            return Utils.fixedNumber(value);

        }
    },
    computed: {
        breadcrumbTitles: function() {

            return [{title: "Configuración"}, this.config.entity.page];

        },
        identityDocumentTypes: function() {

            return this.options?.identityDocumentTypes?.records.map(e => ({code: e.id, label: e.name}));

        },
        statuses: function() {

            return this.options?.companies?.statuses.map(e => ({code: e.code, label: e.label}));

        }
    }
};
</script>
