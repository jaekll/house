<template>
	<div class="m-l-50 m-t-30 w-500">
		<el-form ref="form" :model="form" :rules="rules" label-width="110px">
			<el-form-item label="标题" prop="title">
				<el-input v-model.trim="form.title" class="h-40 w-200"></el-input>
			</el-form-item>
			<el-form-item label="绑定权限标识" prop="rule_name">
				<el-input v-model.trim="form.rule_name" class="h-40 fl w-200" :disabled="true"></el-input>
				<el-button class="fl m-l-30" @click="openRule()">查找</el-button>
			</el-form-item>
			<el-form-item label="菜单类型" prop="menu_type">
				<el-radio-group v-model="form.menu_type">
					<el-radio label="1">普通三级菜单</el-radio>
					<el-radio label="2">单页菜单</el-radio>
					<el-radio label="3">外链</el-radio>
				</el-radio-group>
			</el-form-item>
			<el-form-item label="上级菜单" prop="pid">
				<el-select v-model="form.pid" placeholder="上级菜单" class="w-200">
					<el-option v-for="item in options" :label="item.title" :key="item.id" :value="item.title"></el-option>
				</el-select>
			</el-form-item>
			<el-form-item label="路径">
				<el-input v-model.trim="form.url" class="h-40 w-200"></el-input>
			</el-form-item>
			<el-form-item label="模块" prop="module">
				<el-input v-model.trim="form.module" class="h-40 w-200"></el-input>
			</el-form-item>
			<el-form-item label="所属菜单">
				<el-input v-model.trim="form.menu" class="h-40 w-200"></el-input>
			</el-form-item>
			<el-form-item label="排序">
				<el-input v-model="form.sort" class="h-40 w-200"></el-input>
			</el-form-item>
			<el-form-item>
				<el-button type="primary" @click="add('form')" :loading="isLoading">提交</el-button>
				<el-button @click="goback()">返回</el-button>
			</el-form-item>
		</el-form>
		<ruleList ref="ruleList"></ruleList>
	</div>
</template>

<script>
  import ruleList from './rule.vue'
  
  export default {
    data() {
      return {
        isLoading: false,
        form: {
          title: '',
          rule_name: '',
          rule_id: null,
          pid: '',
          menu_type: '',
          url: '',
          module: '',
          menu: '',
          sort: ''
        },
        options: [{ id: 0, title: '无' }],
        rules: {
          title: [
            { required: true, message: '请输入菜单标题' }
          ],
          menu_type: [
            { required: true, message: '请选择菜单类型' }
          ],
          module: [
            { required: true, message: '请填写菜单模块' }
          ],
          pid: [
            { type: 'number', required: true, message: '请选择上级菜单' }
          ]
        }
      }
    },
    components: {
      ruleList
    },
  }
</script>