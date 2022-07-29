import multer from "multer";

const multer_storage = multer.memoryStorage();

const multer_filter = (req: any, file: any, cb: any) => {
  if (file.mimetype.startsWith("image")) {
    cb(null, true);
  } else {
    cb("error", false);
  }
};

const upload = multer({
  storage: multer_storage,
  fileFilter: multer_filter,
});

// storing the process image in the buffer storage
const upload_image = upload.single("photo");

export default upload_image;
