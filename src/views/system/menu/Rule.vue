<template>
	<el-dialog ref="dialog" custom-class="w-900 h-480 ovf-auto" title="节点列表">
		<div class="pos-rel h-60">
			<el-input placeholder="请输入内容" v-model="keyword" class="search-btn w-300">
				<el-button slot="append" icon="search" @click="searchMsg()"></el-button>
			</el-input>
		</div>
		<div>
			<el-table
			:data="tableData"
			stripe
			style="width: 100%">
				<el-table-column
				prop="type"
				label="类型"
				width="100">
				</el-table-column>
				<el-table-column
				prop="title"
				label="规则名称">
				</el-table-column>
				<el-table-column
				prop="name"
				label="规则标识"
				width="180">
				</el-table-column>
				<el-table-column
				inline-template
				label="操作"
				width="100">
					<div>
						<el-button size="small" @click="selectRule(row)">选择</el-button>
					</div>
				</el-table-column>
			</el-table>
		</div>
	</el-dialog>
</template>

<script>
  
</script>

<style>
  .search-btn {
    position: absolute;
    top: 0px;
    right: 0px;
  }
</style>