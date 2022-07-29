import multer from "multer";

const multerStorage = multer.memoryStorage();

const multerFilter = (req: any, file: any, cb: any) => {
  if (file.mimetype.startsWith("image")) {
    cb(null, true);
  } else {
    cb("error", false);
  }
};

const upload = multer({
  storage: multerStorage,
  fileFilter: multerFilter,
});

// storing the process image in the buffer storage
const uploadImage = upload.single("photo");

export default uploadImage;
