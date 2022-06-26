<template>
    <div class="row">
        <div class="col-md-11">
            <!-- Default box -->
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active pl-5 pr-5" id="order-tab" data-toggle="pill" href="#order"
                               role="tab" aria-controls="order" aria-selected="true">Order</a>
                        </li>
                        <li v-if="moduleActionType === 'show'" class="nav-item">
                            <a class="nav-link pl-5 pr-5" id="order_feedbacks-tab" data-toggle="pill"
                               href="#order_feedbacks" role="tab" aria-controls="order_feedbacks" aria-selected="false">Order
                                Feedbacks</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="order" role="tabpanel" aria-labelledby="order-tab">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <div v-if="validationErrors" class="alert alert-danger pb-0">
                                        <ul class="list-unstyled">
                                            <div v-for="single_errors in validationErrors">
                                                <li v-for="error in single_errors"><i class="la la-info-circle"></i>
                                                    {{ getErr(error) }}
                                                </li>
                                            </div>
                                        </ul>
                                    </div>
                                </div>

                                <div v-if="moduleActionType === 'edit' || moduleActionType === 'show'"
                                     class="form-group col-sm-12 required"><label><strong>Invoice
                                    No</strong></label>
                                    <input type="text" v-model="order.invoice_no" class="form-control"
                                           disabled>
                                </div>

                                <div v-if="moduleActionType === 'edit' || moduleActionType === 'show'"
                                     class="form-group col-sm-12 required"><label><strong>Order
                                    Date</strong></label>
                                    <input type="text" v-model="order.order_date" class="form-control"
                                           disabled>
                                </div>
                                <!-- select from array -->
                                <div class="form-group col-sm-12">
                                    <label :class="{'error-color': validationErrors.user_id}"><strong>Order By</strong>
                                        <span
                                            class="required-custom">*</span></label>
                                    <multiselect
                                        :disabled="moduleActionType === 'show'"
                                        v-model="order.user"
                                        :options="customers"
                                        :close-on-select="true"
                                        :hide-selected="false"
                                        :show-labels="false"
                                        label="name"
                                        track-by="name"
                                        placeholder="Select a customer"
                                    ></multiselect>
                                    <small v-if="validationErrors.user_id"
                                           class="text-danger mt-3">{{ validationErrors.user_id[0] }}</small>

                                </div>    <!-- load the view from type and view_namespace attribute if set -->

                                <!-- text input -->
                                <div class="form-group col-sm-12 required"><label
                                    :class="{'error-color': validationErrors.order_details}"><strong>Order
                                    Details</strong></label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Product</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Sub total</th>
                                                    <th scope="col"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(order,index) in order.order_details"
                                                    :key="`order-${index}`">
                                                    <td>
                                                        <multiselect
                                                            @input="getSellingPrice(order.product, index); calculateTotalPrice()"
                                                            :disabled="moduleActionType === 'show'"
                                                            v-model="order.product"
                                                            :options="products"
                                                            :close-on-select="true"
                                                            :hide-selected="false"
                                                            :show-labels="false"
                                                            label="name"
                                                            track-by="name"
                                                            placeholder="Select a product"
                                                        ></multiselect>
                                                    </td>
                                                    <td>
                                                        <input type="number" v-model="order.quantity"
                                                               :disabled="moduleActionType === 'show'"
                                                               @input="calculateTotalPrice()"
                                                               class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="text" v-model="order.selling_price"
                                                               :disabled="moduleActionType === 'show'"
                                                               @input="calculateTotalPrice()"
                                                               class="form-control"
                                                               disabled>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="total_price"
                                                               :value="isNaN(order.quantity * parseFloat(order.selling_price)) ? 0 : order.quantity * parseFloat(order.selling_price) "
                                                               class="form-control"
                                                               disabled>
                                                    </td>
                                                    <td>
                                                        <button :style="`visibility: ${index != 0 ? 'unset': 'hidden'}`"
                                                                v-if="moduleActionType !== 'show'"
                                                                class="btn btn-sm btn-link text-danger text-nowrap ml-2 border-danger"
                                                                type="button"
                                                                @click="deleteRow(index)">
                                                            &times; Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tbody>

                                                <button v-if="moduleActionType !== 'show'"
                                                        class="btn btn-sm btn-link border-primary ml-3 mt-3"
                                                        type="button"
                                                        @click="addRow()">
                                                    + Add Product
                                                </button>
                                            </table>
                                        </div>
                                    </div>
                                    <small v-if="validationErrors.order_details"
                                           class="text-danger mt-3">{{ validationErrors.order_details[0] }}</small>
                                </div>

                                <!-- text input -->
                                <div class="form-group col-sm-12 required"><label><strong>Total Price</strong></label>
                                    <input type="text" v-model="order.total_price" name="total_price"
                                           class="form-control"
                                           disabled>
                                </div>

                                <div class="form-group col-sm-12">
                                    <label><strong>Status</strong></label>
                                    <select :disabled="moduleActionType === 'show'" name="status" v-model="order.status"
                                            class="form-control">
                                        <option v-for="status in allStatus" :value="status">{{ status }}</option>
                                    </select>
                                </div>

                                <!-- text input -->
                                <div class="form-group col-sm-12 required"><label
                                    :class="{'error-color': validationErrors.customer_name}"><strong>Customer
                                    Name</strong>
                                    <span
                                        class="required-custom">*</span></label>
                                    <input :disabled="moduleActionType === 'show'" type="text" name="name"
                                           class="form-control" v-model="order.customer_name"
                                           :class="{'is-invalid': validationErrors.customer_name}">

                                    <small v-if="validationErrors.customer_name"
                                           class="text-danger mt-3">{{ validationErrors.customer_name[0] }}</small>
                                </div>
                                <!-- load the view from type and view_namespace attribute if set -->

                                <!-- text input -->
                                <div class="form-group col-sm-12 required"><label
                                    :class="{'error-color': validationErrors.customer_email}"><strong>Customer
                                    Email</strong></label>
                                    <input :disabled="moduleActionType === 'show'" type="email" name="name"
                                           class="form-control" v-model="order.customer_email"
                                           :class="{'is-invalid': validationErrors.customer_email}">

                                    <small v-if="validationErrors.customer_email"
                                           class="text-danger mt-3">{{ validationErrors.customer_email[0] }}</small>
                                </div>
                                <!-- load the view from type and view_namespace attribute if set -->

                                <!-- text input -->
                                <div class="form-group col-sm-12 required"><label
                                    :class="{'error-color': validationErrors.customer_contact}"><strong>Customer
                                    Mobile</strong><span
                                    class="required-custom">*</span></label>
                                    <input :disabled="moduleActionType === 'show'" type="text" class="form-control"
                                           v-model="order.customer_contact"
                                           :class="{'is-invalid': validationErrors.customer_contact}">

                                    <small v-if="validationErrors.customer_contact"
                                           class="text-danger mt-3">{{ validationErrors.customer_contact[0] }}</small>
                                </div>
                                <!-- load the view from type and view_namespace attribute if set -->

                                <div class="form-group col-sm-12">
                                    <label :class="{'error-color': validationErrors.customer_address}"><strong>Customer
                                        Address</strong> <span
                                        class="required-custom">*</span></label>
                                    <textarea :disabled="moduleActionType === 'show'"
                                              :class="{'is-invalid': validationErrors.customer_address}"
                                              name="customer_address"
                                              v-model="order.customer_address"
                                              class="form-control"></textarea>
                                    <small v-if="validationErrors.customer_address"
                                           class="text-danger mt-3">{{ validationErrors.customer_address[0] }}</small>
                                </div>
                            </div>
                        </div>
                        <div v-if="moduleActionType === 'show'"  class="tab-pane fade" id="order_feedbacks" role="tabpanel"
                             aria-labelledby="order_feedbacks-tab">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12 col-sm-12 pr-4 pl-4">
                                    <div class="mb-2" style="width: 100%; text-align: end;">
                                        <button type="button" data-toggle="tooltip" data-placement="top"
                                                title="" class="btn btn-default btn-sm"
                                                data-original-title="Refresh List"
                                                @click="refreshFeedbackMessage()">
                                            <i class="las la-sync"></i>
                                        </button>
                                    </div>
                                    <div id="frame" class="rounded">
                                        <div class="content">
                                            <div class="messages" id="messages_div" :key="reRenderFeedbackMsg">
                                                <ul>
                                                    <li :class="message.user_id ==  user_id ? 'replies' : 'sent'" v-if="order.order_feedbacks.length > 0"
                                                        v-for="message in order.order_feedbacks">

                                                        <p>
                                                            {{ message.feedback }} <br><br>
                                                            <small>
                                                                <span>
                                                                    <span> {{ message.user.name }} </span> &nbsp;
                                                                    <span> {{ message.feedback_time }} </span>
                                                                </span>
                                                                <span v-if="message.user_id ==  user_id"
                                                                      class="float-right">{{
                                                                        message.read_status
                                                                    }} </span>
                                                            </small>
                                                        </p>
                                                    </li>
                                                    <li v-if="order.order_feedbacks.length === 0" class="text-center mt-5">
                                                        No feedbacks found
                                                    </li>
                                                </ul>
                                            </div>
                                            <div id="message-input" class="message-input">
                                                <div class="d-flex justify-content-center">
                                                    <textarea id="message_text" class="rounded form-control"
                                                              :class="{'is-invalid': validationErrors.feedback_message_text}"
                                                              v-model="feedback_message_text"
                                                              placeholder="Write your message here..."
                                                    >
                                                    </textarea>
                                                    <button class="btn btn-primary btn-lg my-auto"
                                                            style="height: fit-content;"
                                                            @click="sendFeedbackMessage()"
                                                            type="button">Send
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button v-if="moduleActionType !== 'show'" class="btn btn-success mt-0"
                    @click="actionType='save_and_back'; saveData()">
                <span class="la la-save" role="presentation" aria-hidden="true"></span> Save and back
            </button>

            <button v-if="moduleActionType !== 'show'" @click="actionType='save_and_new'; saveData()" type="button"
                    class="btn btn-outline-primary">
                <span class="la la-folder-open" role="presentation" aria-hidden="true"></span>
                <span data-value="save_and_edit"> Save and new</span>
            </button>

            <a v-if="moduleActionType === 'show'" :href="editUrl"
               class="btn btn-outline-primary">
                <span class="la la-edit" role="presentation" aria-hidden="true"></span>
                <span data-value="Edit"> Edit</span>
            </a>

            <a :href="backUrl" class="btn btn-default">
                <span class="la la-ban"></span> &nbsp;Cancel
            </a>
        </div>
    </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";

export default {
    name      : "OrderCreate",
    components: {
        Multiselect
    },
    props     : [
        'url', 'axios_url', 'user_id', 'module_action_type',
        'method', 'order_data', 'all_customer', 'all_product', 'all_status'
    ],

    data() {
        return {
            validationErrors     : "",
            moduleActionType     : this.module_action_type,
            backUrl              : '/admin/order',
            newUrl               : '/admin/order/create',
            actionType           : 'save_and_back',
            order                : {
                invoice_no      : '',
                order_date      : '',
                user            : [],
                customer_name   : '',
                customer_email  : '',
                customer_contact: '',
                customer_address: '',
                total_price     : '',
                status          : 'Pending',
                order_details   : [],
                order_feedbacks : [],
            },
            orderData            : JSON.parse(this.order_data),
            customers            : JSON.parse(this.all_customer),
            products             : JSON.parse(this.all_product),
            allStatus            : JSON.parse(this.all_status),
            feedback_message_text: '',
            reRenderFeedbackMsg  : 0,
            editUrl              : '',
        }
    },
    created() {
        if (this.moduleActionType === 'edit' || this.moduleActionType === 'show') {
            this.initEdit();
        }
    },
    methods : {
        initEdit() {
            this.order.id               = this.orderData.id;
            this.order.invoice_no       = this.orderData.invoice_no;
            this.order.order_date       = this.orderData.order_date;
            this.order.user             = this.orderData.user;
            this.order.customer_name    = this.orderData.customer_name;
            this.order.customer_email   = this.orderData.customer_email;
            this.order.customer_contact = this.orderData.customer_contact;
            this.order.customer_address = this.orderData.customer_address;
            this.order.total_price      = this.orderData.total_price;
            this.order.status           = this.orderData.status;
            this.order.order_details    = this.orderData.order_details;
            this.order.order_feedbacks  = this.orderData.order_feedbacks;

            if(this.moduleActionType === 'show'){
                this.editUrl = '/admin/order/' + this.orderData.id + '/edit';
            }
        },

        addRow() {
            this.order.order_details.push({
                product      : "",
                quantity     : "",
                selling_price: "",
            });
            this.index++;
        },

        deleteRow(index) {
            this.order.order_details.splice(index, 1);
        },

        getSellingPrice(product, index) {
            this.order.order_details[index].selling_price = product.selling_price;
        },

        calculateTotalPrice() {
            let totalPrice = 0;
            this.order.order_details.forEach(item => {
                totalPrice += parseInt(item.quantity) * parseFloat(item.selling_price);
            });
            this.order.total_price = isNaN(totalPrice) ? 0 : totalPrice;
        },

        getErr(error) {
            if (_.isObject(error)) {
                return _.values(error)[0];
            }
            return error;
        },

        saveData() {
            this.validationErrors = {};
            if (this.order.order_details.length > 0) {
                let error = 0;
                this.order.order_details.forEach((item) => {
                    if (item.product === "" || item.quantity === "") {
                        error++;
                    }
                })
                if (error > 0) {
                    this.validationErrors = {
                        order_details: [
                            'Please select a product and product quantity'
                        ]
                    };
                    return;
                }
            } else {
                this.validationErrors = {
                    order_details: [
                        'Please add at least one product.'
                    ]
                };
                return;
            }

            let params = {
                id              : this.order.id ?? '',
                user_id         : this.order.user.id,
                customer_name   : this.order.customer_name,
                customer_email  : this.order.customer_email,
                customer_contact: this.order.customer_contact,
                customer_address: this.order.customer_address,
                total_price     : this.order.total_price,
                status          : this.order.status,
                order_details   : this.order.order_details.length > 0 ? JSON.stringify(this.order.order_details) : '',
            };

            axios[this.method](`${this.axios_url}`, params)
                .then(response => {
                    new Noty({
                        type: "success",
                        text: 'Saved successfully',
                    }).show();
                    this.validationErrors = "";

                    window.location = this.actionType === 'save_and_back' ? this.backUrl : this.newUrl;
                })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                    console.error(err);
                });
        },

        sendFeedbackMessage() {
            if (this.feedback_message_text.trim() === '') {
                new Noty({
                    type: "error",
                    text: "Please write your message first.",
                }).show();
                return;
            }

            if (this.feedback_message_text.trim().length < 35) {
                new Noty({
                    type: "error",
                    text: "Feedback message must contain at least 35 characters.",
                }).show();
                return;
            }

            let params = {
                order_id: this.order.id,
                feedback: this.feedback_message_text.trim(),
            }
            axios.post('/admin/order/send-feedback', params)
                .then(response => {
                    if (response.data.success) {
                        this.feedback_message_text = '';
                        new Noty({
                            type: "success",
                            text: 'Message has been send successfully!',
                        }).show();
                        this.order.order_feedbacks = response.data.data;
                        this.reRenderFeedbackMsg++;
                    } else {
                        new Noty({
                            type: "error",
                            text: "Can not send message.",
                        }).show();
                    }
                })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                    console.error(err);
                });
        },

        refreshFeedbackMessage() {
            let params = {
                order_id: this.order.id
            }
            axios.post('/admin/order/fetch/feedbacks', params)
                .then(response => {
                    console.log(response);
                    if (response.data.success) {
                        this.order.order_feedbacks = response.data.data;
                        this.reRenderFeedbackMsg++;
                    } else {
                        new Noty({
                            type: "error",
                            text: "Can not refresh messages.",
                        }).show();
                    }
                })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                    console.error(err);
                });
        },
    },
    watch   : {},
    computed: {},
}
</script>

<style scoped>
.required-custom, .error-color {
    color: red;
}

#message-input textarea {
    resize: vertical;
    padding: 10px;
    width: 100%;
    font-size: 14px;
    color: #737373;
    margin-right: 15px;
}

#message-input button {
    margin-right: 5px;
}

/*FeedBack Chatbox*/
#frame {
    width: 100%;
    height: 65vh;
    min-height: 300px;
    max-height: 500px;
    background: #E6EAEA;
}

@media screen and (max-width: 360px) {
    #frame {
        width: 100%;
        height: 100vh;
    }
}

#frame .content {
    float: right;
    width: 100%;
    height: 100%;
    overflow: hidden;
    position: relative;
}

@media screen and (max-width: 735px) {
    #frame .content {
        width: 100%;
        min-width: 300px !important;
    }
}

@media screen and (min-width: 900px) {
    #frame .content {
        width: 100%;
    }
}

#frame .content .contact-profile {
    width: 100%;
    height: 60px;
    line-height: 60px;
    background: #f5f5f5;
}

#frame .content .contact-profile img {
    width: 40px;
    border-radius: 50%;
    float: left;
    margin: 9px 12px 0 9px;
}

#frame .content .contact-profile p {
    float: left;
}

#frame .content .contact-profile .social-media {
    float: right;
}

#frame .content .contact-profile .social-media i {
    margin-left: 14px;
    cursor: pointer;
}

#frame .content .contact-profile .social-media i:nth-last-child(1) {
    margin-right: 20px;
}

#frame .content .contact-profile .social-media i:hover {
    color: #435f7a;
}

#frame .content .messages {
    height: auto;
    min-height: calc(100% - 93px);
    max-height: calc(100% - 93px);
    overflow-y: scroll;
    overflow-x: hidden;
}

@media screen and (max-width: 735px) {
    #frame .content .messages {
        max-height: calc(100% - 105px);
    }
}

#frame .content .messages::-webkit-scrollbar {
    width: 8px;
    background: transparent;
}

#frame .content .messages::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.3);
}

#frame .content .messages ul li {
    display: inline-block;
    clear: both;
    float: left;
    margin: 15px 15px 5px 15px;
    width: calc(100% - 25px);
    font-size: 0.9em;
}

#frame .content .messages ul li:nth-last-child(1) {
    margin-bottom: 20px;
}

#frame .content .messages ul li.sent img {
    margin: 6px 8px 0 0;
}

#frame .content .messages ul li.sent p {
    background: #f5f5f5;
}

#frame .content .messages ul li.replies img {
    float: right;
    margin: 6px 0 0 8px;
}

#frame .content .messages ul li.replies p {
    background: #435f7a;
    color: #f5f5f5;
    float: right;
}

#frame .content .messages ul li img {
    width: 22px;
    border-radius: 50%;
    float: left;
}

#frame .content .messages ul li p {
    display: inline-block;
    padding: 10px 15px;
    border-radius: 20px;
    line-height: 130%;
}

@media screen and (min-width: 735px) {
    #frame .content .messages ul li p {
        max-width: 75%;
    }
}

#frame .content .message-input {
    position: absolute;
    bottom: 0;
    width: 100%;
    z-index: 99;
}

#frame .content .message-input .wrap {
    position: relative;
}

#frame .content .message-input .wrap button {
    float: right;
    border: none;
    width: 50px;
    padding: 12px 0;
    cursor: pointer;
    background: #32465a;
    color: #f5f5f5;
}

@media screen and (max-width: 735px) {
    #frame .content .message-input .wrap button {
        padding: 16px 0;
    }
}

#frame .content .message-input .wrap button:hover {
    background: #435f7a;
}

#frame .content .message-input .wrap button:focus {
    outline: none;
}
</style>
