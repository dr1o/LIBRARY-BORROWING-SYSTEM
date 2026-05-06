# Developer & AI Context Document: Peminjaman & Inventory System Update

## 📌 Architecture Overview
The system has been updated to include a full Role-Based Access Control (RBAC) and an Approval Workflow for equipment loans. The database connection was also migrated from SQLite to MySQL.

## 👥 Role-Based Logic (RBAC)
The application now relies on a `role` column in the `users` table (`admin` vs `user`).
Views and actions are conditionally rendered using `@if(auth()->user()?->role == 'admin')`.
*   **Admin:** Has full CRUD access to Equipment, manual stock manipulation, and a dedicated Approval Dashboard.
*   **User (Mahasiswa):** Can only view equipment (stok > 0) and request to borrow/return.

## 🔄 Loan State Machine & Stock Management
We implemented a multi-step approval workflow in `LoanController.php`. Stock is handled securely to prevent race conditions.

**Borrowing Flow:**
1.  **User Action:** Clicks "Pinjam".
2.  **System:** Creates a `Loan` record with status `Menunggu Persetujuan Pinjam`. Automatically triggers `$equipment->decrement('stok')` to reserve the item so others cannot over-borrow.
3.  **Admin Action:** Clicks "Setujui Pinjam" in the dashboard.
4.  **System:** Updates `Loan` status to `Dipinjam`.

**Returning Flow:**
1.  **User Action:** Clicks "Kembalikan" on their active loan.
2.  **System:** Updates `Loan` status to `Menunggu Persetujuan Kembali`. (Stock remains checked out).
3.  **Admin Action:** Clicks "Setujui Kembali".
4.  **System:** Updates `Loan` status to `Dikembalikan` and triggers `$equipment->increment('stok')` to officially return the item to the inventory.

## 📂 Core Files Modified / Created
If an AI agent needs to modify the borrowing logic, reference these files:

*   **`routes/web.php`:** 
    *   Added isolated routes for stock management (`equipments.increase`, `decrease`, `clear`).
    *   Added user loan routes (`loans.store`, `loans.return`, `loans.index`).
    *   Added admin approval routes (`loans.approve_borrow`, `loans.approve_return`, `loans.admin`).
*   **`app/Http/Controllers/LoanController.php`:** 
    *   Houses the core logic for the state machine and stock increment/decrement.
*   **`resources/views/layouts/navigation.blade.php`:** 
    *   Updated with conditional navigation links for Admins vs Users.
*   **`resources/views/equipments/index.blade.php`:** 
    *   Combined Admin controls and User "Pinjam" buttons behind `@if` role checks.
*   **`resources/views/loans/index.blade.php`:** 
    *   The User's history page showing their active and past loans.
*   **`resources/views/loans/admin.blade.php`:** 
    *   **[NEW FILE]** The Admin's centralized dashboard for viewing pending requests and clicking approval buttons.