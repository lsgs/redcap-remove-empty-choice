********************************************************************************
# REDCap External Module: Remove Empty Choice

Luke Stevens, Murdoch Children's Research Institute https://www.mcri.edu.au

[https://github.com/lsgs/redcap-remove-empty-choice](https://github.com/lsgs/redcap-remove-empty-choice)
********************************************************************************

## Summary

`@REMOVE-EMPTY-CHOICE` action tag for dropdown list and SQL fields that removes the default, empty list option, effectively making the first option the default choice.

Notes:
* Applies to SQL fields, and is hence useful for automatic selection of a single option returned by the query. 
* The tag is ignored for all field types except <code>dropdown</code> list <code>sql</code>, or where the \"auto-complete\" option is selected.