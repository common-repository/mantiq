<div v-dragscroll class="bg-primary-light h-100 overflow-auto cursor-grab invisible-scrollbars pb-4">
    <blocks-tree @click="resetFocus"
                 :data="workflow.tree"
                 :collapsable="false"
                 :props="{children: 'children',  key: 'uid'}"
                 :label-class-name="(data) => currentActiveNodes.includes(data.uid) ? 'is-active-node' : ''">
        <template #node="{data, parent, context, index}" @click="setFocus(data)">
            <div @click.stop="setFocus(data)">
                <component :key="'node-' + data.uid"
                           :id="'node-' + data.uid"
                           :is="data.tree_component"
                           :workflow="workflow"
                           :node="data"
                           :parent="parent"
                           :index="index"
                           @removed="resetFocus"/>
                <NewNode :node="data" :parent="parent"/>
            </div>
        </template>
    </blocks-tree>
</div>
