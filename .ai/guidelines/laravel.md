This is a demo project for a web development basics course: Pinbook, a travel journal. Users write trips made of places (stops). Models: User, Trip, Place, Category, Comment. Place and Category are many-to-many.
Don't do any advanced stuff out of the box. Build only what has been taught in class.
Keep foreign keys in tables pure, no ->cascade etc stuff.

## Commits

Never commit without the explicit agreement of the user. Do not commit automatically at the end of a task, and do not assume that a finished change should be committed. Always ask first and wait for a clear yes.

Use a single line commit message in this format:

```
TYPE :emoji: Description
```

- Write the type in uppercase, followed by a space, a colon, a space, the emoji, a space, and the description.
- Do not add a body, bullet points, or a "Co-authored-by" trailer.
- Write the description in sentence case, starting with a capital letter and describing the change in the present tense.
- Keep the description short and specific.

Types and emoji used in this project:

| Type | Emoji | Use for |
| --- | --- | --- |
| INIT | :seedling: | The initial commit |
| FEATURE | :sparkles: | New functionality |
| BUGFIX | :bug: | Fixing incorrect behavior |
| REFACTOR | :hammer: | Restructuring code without changing behavior |
| DESIGN | :art: | Styling and layout changes |
| CONTENT | :pencil: | Content and documentation changes |
| SECURITY | :key: | Protecting data and routes |
| UPDATE | :package: | Updating packages and versions |

Examples from this project:

```
FEATURE :sparkles: Add trip details
BUGFIX :bug: Leave the last trips without comments
REFACTOR :hammer: Show the menu in the header and the footer
DESIGN :art: Update the app layout
CONTENT :pencil: Add project specific rules
```

Make one commit per logical change (atomic commits). If a task touches two separate concerns, split it into separate commits, ordered so that the application keeps working after each commit.

Only stage files that belong to the change being committed. Leave unrelated modified or untracked files out of the commit.
