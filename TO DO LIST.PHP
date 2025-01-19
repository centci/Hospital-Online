
-- validated, compare duplicate username
-- added more new function in Main Model Class:
  ** countWhere();
  ** generateUniqueId(); every second ids of every table can now be generated dynamically if its Required, using this function.
  ** attachRelatedData(),processSpecialFields($data),and getRelatedData() these three functions collect information from any table dynamically, provided you key in
  the table you intend to get data from and its column you intend to retrive data from, you key in the column from the $row you intend to compare with
  the column you intend to get data from.

  feat(Model): Add dynamic data validation, ID generation, and relationship handling

  - **Validated Duplicate Username Check:**
    Ensure duplicate usernames are detected and avoided during user creation.

  - **Added New Functions in Main Model Class:**
    1. `countWhere()`: Dynamically count records matching specified conditions.
    2. `generateUniqueId()`: Create unique IDs for database records dynamically, with second-based precision.
    3. `attachRelatedData()`: Dynamically attach related data from another table based on specified relationships.
    4. `processSpecialFields($data)`: Process and compute special fields (e.g., combining `firstname` and `lastname` into `fullname`).
    5. `getRelatedData()`: Retrieve related data dynamically from specified tables and columns.

  - **Function Descriptions:**
    - `attachRelatedData()`, `processSpecialFields($data)`, and `getRelatedData()`:
      These functions collectively enable dynamic handling of relational data by allowing the user to:
      - Provide the target table and column for data retrieval.
      - Specify the `key` or column from the current dataset used for comparison.
      - Dynamically process data and attach results for easier data manipulation.

  Breaking Changes:
  - None.
