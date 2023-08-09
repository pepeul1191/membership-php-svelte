-- migrate:up

ALTER TABLE memberships
ADD COLUMN membership_state_id INT,
ADD CONSTRAINT fk_memberships_membership_states
FOREIGN KEY (membership_state_id) REFERENCES membership_states(id);

-- migrate:down

ALTER TABLE memberships 
DROP FOREIGN KEY fk_memberships_membership_states;
ALTER TABLE memberships 
DROP COLUMN membership_state_id;