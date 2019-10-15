<div id="lb-container-header">
    <div class="lb-header-right"><h3>Configuration</h3></div>
    <div class="lb-header-left lb-header-left-config-talents">
        <a href="<?php echo $this->createUrl('/lbTalent/default/index'); ?>" class="btn"><i class="icon-arrow-left"></i> Back</a>
    </div>
</div><br>

<?php 
    $model_skill = new LbTalentSkills();
    $model_course = new LbTalentCourses();
    $model_course_skills = new LbTalentCourseSkills();
    $this->widget('bootstrap.widgets.TbTabs', array(
                    'type'=>'tabs', // 'tabs' or 'pills'
                    'encodeLabel'=>false,
                    'tabs'=> 
                    array(
                        array('id'=>'tab1','label'=>'<strong>'.Yii::t('lang','Training Courses').'</strong>',
                            'content'=>$this->renderPartial('training_course',array(
                                'model'=>$model_course,
                                'model_c_skills'=>$model_course_skills,
                                'model_skill'=>$model_skill,
                            ),true),'active'=>true,
                        ),
                        array('id'=>'tab2','label'=>'<strong>'.Yii::t('lang','Skills').'</strong>', 
                        'content'=> $this->renderPartial('skills', array(
                                'model'=>$model_skill,
                            ),true), 'active'=>false),
                    )
    ));
 ?>