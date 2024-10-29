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

|Without action tag|Tagged with `@REMOVE-EMPTY-CHOICE`|
|-|-|
|![image](https://github.com/user-attachments/assets/236ef92a-217d-4f62-b8b8-19b10795bd77)|![image](https://github.com/user-attachments/assets/abd47aaa-438a-47d7-b8fa-cd051d64f081)|
