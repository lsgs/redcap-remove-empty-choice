<?php
/**
 * REDCap External Module: Remove Empty Choice
 * @author Luke Stevens, Murdoch Children's Research Institute
 */
namespace MCRI\RemoveEmptyChoice;

use ExternalModules\AbstractExternalModule;

class RemoveEmptyChoice extends AbstractExternalModule
{
    const ACTION_TAG = '@REMOVE-EMPTY-CHOICE';
    protected $isSurvey = false;
    protected $instrument;
    protected $taggedFields = [];

    public function redcap_data_entry_form_top($project_id, $record, $instrument, $event_id, $group_id, $repeat_instance) {
        $this->isSurvey = false;
        $this->instrument = $instrument;
        $this->pageTop();
    }

    public function redcap_survey_page_top($project_id, $record, $instrument, $event_id, $group_id, $survey_hash, $response_id, $repeat_instance) {
        $this->isSurvey = true;
        $this->instrument = $instrument;
        $this->pageTop();
    }

    protected function pageTop() {
        // find any tagged dropdown lsit fields on current instrument
        $this->setTaggedFields();
        if (!is_array($this->taggedFields) || count($this->taggedFields)===0) return;

        $this->initializeJavascriptModuleObject();
        ?>
        <!-- RemoveEmptyChoice: Begin -->
        <script type="text/javascript">
            $(function(){
                var module = <?=$this->getJavascriptModuleObjectName()?>;
                module.taggedFields = JSON.parse('<?=json_encode($this->taggedFields)?>');
                module.init = function() {
                    module.taggedFields.forEach(fldName => {
                        let tf = $('select[name='+fldName+']');
                        if ($(tf).val()=='') {
                            $(tf).prop('selectedIndex', 1).trigger('change');
                        }
                        $(tf).find('option:first').remove();
                    });
                };
                $(document).ready(function(){
                    module.init();
                });
            });
        </script>
        <!-- RemoveEmptyChoice: End -->
        <?php
    }

    /**
     * setTaggedFields()
     * Populate the tagged fields array with names of fields on the current instrument/survey page tagged with the module action tag
     */
    public function setTaggedFields() : void {
        $this->taggedFields = array();
                
        $instrumentFields = \REDCap::getDataDictionary('array', false, true, $this->instrument);
        
        if ($this->isSurvey && isset($_GET['__page__'])) {
            global $pageFields;
            $thisPageFields = array();
            foreach ($pageFields[$_GET['__page__']] as $pf) {
                $thisPageFields[$pf] = $instrumentFields[$pf];
            }
        } else {
            $thisPageFields = $instrumentFields;
        }

        $pattern = "/".static::ACTION_TAG."\b/";
        foreach ($thisPageFields as $fieldName => $fieldDetails) {
            if (!in_array($fieldDetails['field_type'], ['dropdown','sql'])) continue;
            if (!empty($fieldDetails['text_validation_type_or_show_slider_number'])) continue;

            if (preg_match($pattern, $fieldDetails['field_annotation'])) {
                $this->taggedFields[] = $this->escape($fieldName);
            }
        }
    }
}
