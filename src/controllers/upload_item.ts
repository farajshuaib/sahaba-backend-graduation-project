import express, { Request, Response } from "express";
import multer from "multer";
import ipfsAPI from "ipfs-api";

//Connceting to the ipfs network via infura gateway
const ipfs = ipfsAPI("ipfs.infura.io", "5001", { protocol: "https" });

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
export const upload_image = upload.single("photo");

interface MulterRequest extends Request {
  file: any;
}
export const upload_item = async (req: Request, res: Response) => {
  const file = (req as MulterRequest).file;

  if (!file) {
    res.status(400).json({ message: "File not found" });
    return;
  }

  try {
    const result = await ipfs.add(file.buffer);
    console.log("result", result[0]);
    const hash = result[0].hash; // should saved to the db to return it from ipfs.get() in the future
    res.status(200).json({
      message: "success",
      data: { path: `https://ipfs.infura.io/ipfs/${result[0].path}` },
    });
  } catch (error) {
    console.log("ipfs image upload error: ", error);
    res.status(500).send({ message: "upload failed", error: error });
  }
};
