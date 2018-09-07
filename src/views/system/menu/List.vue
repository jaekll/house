<template>
	<div>
		<div class="m-b-20">
  		    <el-button type="primary">
  		    	<router-link class="btn-link-large add-btn" to="add">
  		  			添加菜单
  				</router-link>
  		    </el-button>
		</div>
		<el-table
		:data="tableData"
		style="width: 100%"
		@selection-change="selectItem">
			<el-table-column
			type="selection"
			:context="_self"
			width="50">
			</el-table-column>
			<el-table-column
			prop="html"
			label="上级菜单"
			width="150">
			</el-table-column>
			<el-table-column
			prop="title"
			label="标题">
			</el-table-column>
			<el-table-column
			prop="level"
			label="类型"
			width="200">
			</el-table-column>
			<el-table-column
			inline-template
			label="状态"
			width="100">
				<div>
					{{ row.pid | pid}}
				</div>
			</el-table-column>
			<el-table-column
			label="操作"
			inline-template
			width="200">
				<div>
					<span>
						<router-link :to="{ name: 'menuEdit', params: { id: row.id }}" class="btn-link edit-btn">
						编辑
						</router-link>
					</span>
					<span>
						<el-button
						size="small"
						type="danger"
						@click="confirmDelete(row)">
						删除
						</el-button>
					</span>
				</div>
			</el-table-column>
		</el-table>
		<div class="pos-rel p-t-20">
			<btnGroup :selectedData="multipleSelection" :type="'menus'"></btnGroup>
		</div>
	</div>
</template>

<script>
    import btnGroup from '../../common/btnGroup.vue';
	import {getMenuList} from '../../../api/api';

	export default {
		components:{
            btnGroup
        },
		data(){
			return{
				tableData:[],
				multipleSelection:[]
			}	
		},
		methods:{
			selectItem(val){
				this.multipleSelection = val
			}
		},
		mounted(){
			console.log('menu')
			let param = {}
			// let param = {
			// 		page: this.page,
			// 		name: this.filters.name
			// };
			// this.listLoading = true;
			getMenuList(param).then(res=>{
				console.log(res.data)
				this.tableData = res.data
			})
		}
	}
</script>
<style>
	
</style>