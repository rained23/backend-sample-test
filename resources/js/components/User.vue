<template>
<div>
   <table class="table">
        <thead>
            <tr>
                <th colspan="5"></th>
                <th class="text-right"> Bulk Tag</th>                
                <th>
                    <select v-model="selectedTag">                        
                        <option v-for="tag in tags" :value="tag.name" :key="tag.id">{{tag.name}}</option>
                    </select> 
                     <button type="button" @click="bulkAction" class="btn btn-primary">
                        <span class="oi oi-tags"></span>
                    </button> 
                </th>

            </tr>
            <tr>
                <th scope="col"><input type="checkbox" v-model="selectAll"></th>
                <th scope="col">ID</th>
                <th scope="col">Kind</th>
                <th scope="col">E-mail</th>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>                                
                <th scope="col">Action</th>
            </tr>
        </thead>
        
        <tbody>                
            <tr v-for="user in users" :key="user.id">                       
                <td> <input type="checkbox" v-model="selected" :value="user.id"  number/> </td>
                <td> {{user.id}}</td>         
                <td>{{ user.type }}</td>
                <td>{{ user.email}}</td>
                <td>{{ user.name}}</td>
                <td>{{ user.phone }}</td>
                
                <td> 
                    
                    
                            <a class="btn btn-outline-primary" :href="'/users/'+user.id">
                                <span class="oi oi-eye"></span>
                            </a>
                            <a class="btn btn-outline-primary" :href="'/users/'+user.id+'/edit'">
                                <span class="oi oi-pencil"></span>
                            </a>
                        <button type="button" @click="destroy(user.id)" class="btn btn-outline-danger"><span class="oi oi-trash"></span></button>
                    
                </td>
            </tr>                                                              
        
        </tbody>
    </table>  
          
</div>
</template>

<script>
export default {
    props: ['userDs','tags'],
    data() {
        return {
            users: this.userDs,
            selected: [],
            selectedTag: null
        }
    },    
    methods: {
        destroy(id) {
          if(confirm('Are you sure you want to remove this user?')) {
              axios.delete('users/'+id)
              .then(response => {
                  this.users = _.remove(this.users, function (user) {
                    return user.id !== id;
                });
              });
          }
      },
      bulkAction() {
          if(this.selected.length < 1)
          {
              alert('Please select users');
              return 1;
          }

          axios.post('users/tag', { ids: this.selected, tag_name: this.selectedTag})
            .then(response => {
                console.log(response);
                alert('Users has been tagged');
            });
      }
    },
    computed: {
        selectAll: {
            get: function () {
                return this.users ? this.selected.length == this.users.length : false;
            },
            set: function (value) {
                var selected = [];

                if (value) {
                    this.users.forEach(function (user) {
                        selected.push(user.id);
                    });
                }

                this.selected = selected;
            }
        }
    }
}
</script>
