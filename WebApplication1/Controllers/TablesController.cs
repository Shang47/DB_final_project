using System;
using System.Collections.Generic;
using System.Data;
using System.Data.Entity;
using System.Linq;
using System.Net;
using System.Web;
using System.Web.Mvc;
using WebApplication1.Models;
using System.Security.Cryptography;
using System.Text;

namespace WebApplication1.Controllers
{
    public class TablesController : Controller
    {
        private Database1Entities1 db = new Database1Entities1();
        public static string Enscrypt(string plainText)
        {
            byte[] data = Encoding.Default.GetBytes(plainText);
            SHA256 sha256 = new SHA256CryptoServiceProvider();
            byte[] result = sha256.ComputeHash(data);
            return Convert.ToBase64String(result);
        }
        public ActionResult Login(loginModel form)
        {
            ViewBag.username = form.FormUsername;
            ViewBag.password = form.FormPassword;
            var r = (from a in db.Table
                    where a.username == form.FormUsername
                    select a).FirstOrDefault();
            if (r == null) 
            {
                ViewBag.message = "帳號密碼錯誤";
                return View();
            }
            string SaltAndFormPassword = String.Concat(r.Id, form.FormPassword);
            string FormPassword = Enscrypt(SaltAndFormPassword);
            ViewBag.inputHPW = FormPassword;
            ViewBag.savedHPW = r.password;
            if (string.Compare(FormPassword, r.password, false) == 0) ViewBag.message = "登入成功";
            else ViewBag.message = "帳號密碼錯誤";
            return View();
        }
        [Authorize]
        public ActionResult Test()
        {
            return View();
        }

        // GET: Tables
        public ActionResult Index()
        {
            return View(db.Table.ToList());
        }

        // GET: Tables/Details/5
        public ActionResult Details(Guid? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            Table table = db.Table.Find(id);
            if (table == null)
            {
                return HttpNotFound();
            }
            return View(table);
        }

        // GET: Tables/Create
        public ActionResult Create()
        {
            return View();
        }

        // POST: Tables/Create
        // 若要避免過量張貼攻擊，請啟用您要繫結的特定屬性。
        // 如需詳細資料，請參閱 https://go.microsoft.com/fwlink/?LinkId=317598。
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Create([Bind(Include = "Id,username,password")] Table table)
        {
            if (ModelState.IsValid)
            {
                table.Id = Guid.NewGuid();
                string SaltAndPassword = String.Concat(table.Id, table.password);
                string hashPW = Enscrypt(SaltAndPassword);
                table.password = hashPW;
                db.Table.Add(table);
                db.SaveChanges();
                return RedirectToAction("Index");
            }

            return View(table);
        }

        // GET: Tables/Edit/5
        public ActionResult Edit(Guid? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            Table table = db.Table.Find(id);
            if (table == null)
            {
                return HttpNotFound();
            }
            return View(table);
        }

        // POST: Tables/Edit/5
        // 若要避免過量張貼攻擊，請啟用您要繫結的特定屬性。
        // 如需詳細資料，請參閱 https://go.microsoft.com/fwlink/?LinkId=317598。
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Edit([Bind(Include = "Id,username,password")] Table table)
        {
            if (ModelState.IsValid)
            {
                db.Entry(table).State = EntityState.Modified;
                db.SaveChanges();
                return RedirectToAction("Index");
            }
            return View(table);
        }

        // GET: Tables/Delete/5
        public ActionResult Delete(Guid? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            Table table = db.Table.Find(id);
            if (table == null)
            {
                return HttpNotFound();
            }
            return View(table);
        }

        // POST: Tables/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public ActionResult DeleteConfirmed(Guid id)
        {
            Table table = db.Table.Find(id);
            db.Table.Remove(table);
            db.SaveChanges();
            return RedirectToAction("Index");
        }

        protected override void Dispose(bool disposing)
        {
            if (disposing)
            {
                db.Dispose();
            }
            base.Dispose(disposing);
        }
    }
}
