<?php

class DefaultController extends Controller
{
	public function actionIndex($entity_type,$entity_id)
	{       
//            $this->renderPartial('index',array(
//                'entity_type'=>$entity_type,
//                'entity_id'=>$entity_id,
//            ));
	}
        
        static public function getSubscriptionId()
        {
            $subcription_id = LBApplication::getCurrentlySelectedSubscription(); // Truyen tham so subcription_id cua he thong tich hop vao day.
            return $subcription_id;
        }
        
        public function actionLoabPCheckList()
        {
            $entity_type = $_POST['entity_type'];
            $entity_id = $_POST['entity_id'];
            
            $this->renderPartial('process_checklist.views.default.form_process_checklist',array(
                'entity_type'=>$entity_type,
                'entity_id'=>$entity_id,
            )); 
        }
        
        public function actionDeletePCheckListByEntity()
        {
            $entity_type=$_POST['entity_type'];
            $entity_id=$_POST['entity_id'];
            $pc_id=$_POST['pc_id'];
            
            $ItemRel = ProcessChecklistItemRel::model()->deleteAll("pcir_entity_type='".$entity_type."' AND pcir_entity_id=".  intval($entity_id)." AND pc_id=".intval($pc_id));
            
            if($ItemRel)
                echo '{"status":"success"}';
            else
                echo '{"status":"fail"}';
        }
}