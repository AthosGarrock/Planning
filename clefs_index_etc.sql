CREATE INDEX FK_Day_Entry ON entry (de_fk);



ALTER TABLE entry ADD CONSTRAINT fk_de_ref
FOREIGN KEY (de_fk) REFERENCES day_entry(id)
ON DELETE {CASCADE};  