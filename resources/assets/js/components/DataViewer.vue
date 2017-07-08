<template>
  <div class="dv">
      <div class="dv-header">
          <div class="dv-header-title">
         {{title}}
          </div>
          <div class="dv-header-columns">
              <span>Search:</span>
              <select name="" id="" class="dv-header-select" v-model="query.search_column">
                  <option v-for="column in columns" :value="column">{{column}}</option>
              </select>
          </div>
          <div class="dv-header-operators">
              <select name="" id=""  class="dv-header-select" v-model="query.search_operator">
                  <option :value="key" v-for="(value , key) in operators">{{value}} </option>
              </select>
          </div>
          <div class="dv-header-search">
             <input type="text" name="" id="" class="dv-header-input" v-model="query.search_input">
          </div>
          <div class="dv-header-submit">
              <button @click="fetchIndexData()" class="dv-header-btn">
                  filter
              </button>
          </div>
      </div>
      <div class="dv-body">
          <table class="dv-table">
              <thead>
                  <tr>
                      <th v-for="column in columns" @click="toggleOrder(column)">
                          <span class="dv-table-column" v-if="query.column==column">
                <span v-if="query.direction==='desc'">
                          &uarr;
                              </span>
                              <span v-if="query.direction==='asc'">
                              &darr;
                              </span>
                          </span>
                          {{column}}
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="row in model.data">
                      <td v-for="(value , key) in row">
                          {{value}}
                      </td>
                  </tr>
              </tbody>
          </table>
      </div>
      <div class="dv-footer">
          <div class="dv-footer-item">
              <span>Display {{model.from}}-{{model.to}}  of {{model.total}} rows </span>
          </div>
          <div class="dv-footer-item">
              <div class="dv-footer-sub">
                  <span>Rows per page</span>
                  <input type="text"@keyup.enter="fetchIndexData()" v-model="query.per_page" class="dv-footer-input"  name="" id="">
              </div>
              <div class="dv-footer-sub">
                  <button class="dv-footer-btn" @click="prev()">&laquo;</button>
                  <button class="dv-footer-btn" @click="next()">&raquo;</button>
              </div>
          </div>
      </div>
  </div>
</template>
<script>
        import axios from 'axios';
    export default{
        props:['source','title'],
        data(){
            return{
                model:{},
                columns:{},
                query:{
                    page:1,
                    column:'id',
                    direction:'desc',
                    per_page:10,
                    search_column:'id',
                    search_input:'1',
                    search_operator:'greater_than_or_qual_to',
                },
                operators:{
                    equal:'=',
                    not_equal:'<>',
                    less_than:'<',
                    greater_than:'>',
                    less_than_or_equal_to:'<=',
                    greater_than_or_qual_to:'>=',
                    in:'IN',
                    like:'LIKE'
                },
            }
        },
        created(){
            this.fetchIndexData();
        },
        methods:{
            prev(){
                if(this.model.prev_page_url){
                    this.query.page--
                    this.fetchIndexData()
                }
            },
             next(){
                if(this.model.next_page_url){
                    this.query.page++
                    this.fetchIndexData()
                }
            },
            toggleOrder(column){
                if(column===this.query.column){
                    this.query.direction=='desc'?this.query.direction='asc':this.query.direction='desc'
                   this.fetchIndexData()
                }else{ 
                    this.query.column=column
                    this.query.direction=='desc'
                   this.fetchIndexData()
                    
                }
            },
            fetchIndexData(){
                var vm=this
                axios.get(
                   `${this.source}?column=${this.query.column}&direction=${this.query.direction}&page=${this.query.page}&per_page=${this.query.per_page}&search_input=${this.query.search_input}&search_operator=${this.query.search_operator}&search_column=${this.query.search_column}`)
                .then(function(response){
                    vm.columns=response.data.columns;
                    vm.model=response.data.model;
                    
                })
                .catch(function(response){
                    console.log(response)
                })
            }
        }
    }

</script>