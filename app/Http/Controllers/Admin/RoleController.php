<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->perm('role-table'))->only(['index', 'show']);
        $this->middleware($this->perm('role-add'))->only(['create', 'store']);
        $this->middleware($this->perm('role-edit'))->only(['edit', 'update']);
        $this->middleware($this->perm('role-delete'))->only(['destroy', 'delete']);
    }

    // Permissions grouped by module (used in create/edit UI)
    public static function permGroups(): array
    {
        return [
            'Roles & Employees'    => ['role-table', 'role-add', 'role-edit', 'role-delete', 'employee-table', 'employee-add', 'employee-edit', 'employee-delete'],
            'Activity Log'         => ['activity-log-table', 'activity-log-delete'],
            'Students'             => ['student-table', 'student-add', 'student-edit', 'student-delete'],
            'Teachers'             => ['teacher-table', 'teacher-add', 'teacher-edit', 'teacher-delete'],
            'Courses'              => ['course-table', 'course-add', 'course-edit', 'course-delete'],
            'Course Content'       => ['course-content-add', 'course-content-edit', 'course-content-delete'],
            'Categories'           => ['category-table', 'category-add', 'category-edit', 'category-delete'],
            'Subjects'             => ['subject-table', 'subject-add', 'subject-edit', 'subject-delete'],
            'Exams'                => ['exam-table', 'exam-add', 'exam-edit', 'exam-delete'],
            'Question Bank'        => ['question-bank-table', 'question-bank-add', 'question-bank-edit', 'question-bank-delete'],
            'Previous Exams'       => ['previous-exam-table', 'previous-exam-add', 'previous-exam-edit', 'previous-exam-delete'],
            'Worksheets'           => ['worksheet-table', 'worksheet-add', 'worksheet-edit', 'worksheet-delete'],
            'Educational Notes'    => ['educational-note-table', 'educational-note-add', 'educational-note-edit', 'educational-note-delete'],
            'Weekly Planner'       => ['weekly-planner-table', 'weekly-planner-add', 'weekly-planner-edit', 'weekly-planner-delete'],
            'Enrollments'          => ['enrollment-table', 'enrollment-edit', 'enrollment-delete'],
            'Cards'                => ['card-table', 'card-add', 'card-edit', 'card-delete', 'card-number-table', 'card-number-add', 'card-number-edit', 'card-number-delete'],
            'Banners'              => ['banner-table', 'banner-add', 'banner-edit', 'banner-delete'],
            'Announcements'        => ['announcement-table', 'announcement-add', 'announcement-edit', 'announcement-delete'],
            'Notifications'        => ['notification-send'],
            'Cities'               => ['city-table', 'city-add', 'city-edit', 'city-delete'],
            'Point of Sale'        => ['pos-table', 'pos-add', 'pos-edit', 'pos-delete'],
            'Contact Messages'     => ['contact-message-table', 'contact-message-delete'],
            'Settings'             => ['setting-edit'],
        ];
    }

    public function index(Request $request)
    {
        $roles = Role::withCount('permissions')
            ->where('guard_name', 'admin')
            ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%$s%"))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permGroups = self::permGroups();
        $allPerms   = Permission::where('guard_name', 'admin')->pluck('id', 'name');
        return view('admin.roles.create', compact('permGroups', 'allPerms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100|unique:roles,name',
            'perms'   => 'nullable|array',
            'perms.*' => 'integer|exists:permissions,id',
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'admin']);
        $role->syncPermissions(Permission::whereIn('id', $request->input('perms', []))->get());

        return redirect()->route('admin.role.index')->with('success', 'Role created successfully.');
    }

    public function edit(int $id)
    {
        $role       = Role::findOrFail($id);
        $permGroups = self::permGroups();
        $allPerms   = Permission::where('guard_name', 'admin')->pluck('id', 'name');
        $assigned   = $role->permissions->pluck('id')->toArray();
        return view('admin.roles.edit', compact('role', 'permGroups', 'allPerms', 'assigned'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name'    => 'required|string|max:100|unique:roles,name,' . $id,
            'perms'   => 'nullable|array',
            'perms.*' => 'integer|exists:permissions,id',
        ]);

        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);
        $role->syncPermissions(Permission::whereIn('id', $request->input('perms', []))->get());

        return redirect()->route('admin.role.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(int $id)
    {
        Role::findOrFail($id)->delete();
        return back()->with('success', 'Role deleted.');
    }

    // Legacy AJAX delete endpoint (kept for backward compat)
    public function delete(Request $request)
    {
        Role::where('id', $request->id)->delete();
        return 1;
    }
}
