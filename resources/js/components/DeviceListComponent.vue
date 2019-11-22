<template>
        <div class="page-wrapper">
            <div class="card">
                <div class="card-header">
                    Devices Assigned to : {{name}}
                    <div class="float-right">
                        <input type="text" v-model="curate" placeholder="Search">
                    </div>
                </div>
                <div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Item Info</th>
                            <th scope="col">Item Serial</th>
                            <th scope="col">Assigned Date</th>
                            <th scope="col">Assigned By</th>
                            <th scope="col">Device Status</th>
                            <th scope="col">Request Access</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(result, key) in curated">
                            <td scope="row">{{key+1 + '.' }}</td>
                            <td>{{result.item_name}}</td>
                            <td>{{result.item_serial}}</td>
                            <td>{{result.assigned_date | humanize}}</td>
                            <td>{{result.assignee}}</td>
                            <td>{{result.status | format }}</td>
                            <td><a class="btn btn-sm" :class="result.isSubscribed ? 'btn-success disabled' : 'btn-primary'"  href="" @click.prevent="subscribe(result)" v-text="result.isSubscribed ? 'Subscribed' : 'Request'"></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</template>

<script>

    import {user} from "../utilities/auth";
    import moment from 'moment'
    import {devicesUrl, subscriptionsUrl, subscriptionsRemoteUrl} from "../utilities/constants";

    export default {
        props: ['subscriptions'],

        data() {
            return {
                results: [],
                curate:'',
                name: user.name()
            }
        },

        filters:{
            format: function(value) {
                return value === "1" ? 'Assigned':'Returned';
            },

            humanize: function (value) {
                return moment(value).fromNow();
            }

        },

        async mounted() {
            let subscribedDevices = [];
            this.subscriptions.map((subscription) => {
                subscribedDevices.push(subscription.item_id);
            });

            await axios.get(`${devicesUrl}${user.email()}`).then(({data}) => {
                data.results.map((device) => {
                    device['isSubscribed'] = false;
                   if (subscribedDevices.indexOf(device.item_id) !== -1) {
                       device['isSubscribed'] = true;
                   }
                });

                this.results = data.results;


            }).catch(error => {
                console.log('Error')
            });
        },

        computed: {
            curated () {
                return this.results.filter((result) => {
                    return result.item_name.toLowerCase().indexOf(this.curate.toLowerCase()) >= 0;
                });
            }
        },

        methods:{
             async subscribe(result) {
                 result.isSubscribed = true;
                 await axios.post(`${subscriptionsUrl}`, {'item_id':result.item_id,'item_name': result.item_name}).then(({data}) => {
                     console.log(data)

               }).catch(error => {
                   console.log(error)
               })
            }
        }
    }
</script>
